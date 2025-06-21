<?php

namespace App\Http\Controllers\donatur;

use App\Http\Controllers\Controller;
use App\Models\DeliveryService;
use App\Models\DonationItem;
use App\Models\DonationProposal;
use App\Models\Profile;
use App\Models\ProposalItem;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DonaturViewController extends Controller
{
    public function index() {
        $proposals = DonationProposal::with(['donationType', 'user', 'proposalItems'])->where('status', true)->get();
    
        // Ambil semua donation item terkait proposal
        $donations = DonationItem::whereIn('id_donation_proposal', $proposals->pluck('id'))->get();
    
        $groupedDonations = $donations->groupBy('id_donation_proposal');

        foreach ($proposals as $proposal) {
            // Total barang dari proposal
            $proposal->total_quantity = $proposal->proposalItems->sum(function ($item) {
                return (int) $item->quantity;
            });

            // Ambil donation berdasarkan id proposal, jika tidak ada maka buat collection kosong
            $donationItems = $groupedDonations->get($proposal->id, collect());

            // Total yang sudah didonasikan
            $donatedQty = $donationItems->sum('quantity');

            $proposal->donated_quantity = $donatedQty;

            // Hitung persentase
            $proposal->donation_percent = $proposal->total_quantity > 0
                ? round(($donatedQty / $proposal->total_quantity) * 100)
                : 0;
        }

        $proposals = $proposals->filter(function ($proposal) {
            return $proposal->total_quantity != $proposal->donated_quantity;
        });
        
        // dd($proposals);

        return view('pages.donatur.index', compact('proposals'));
    }

    public function detailProposal($id) {
        // Ambil proposal beserta relasi terkait
        $proposal = DonationProposal::with(['donationType', 'user', 'proposalItems'])->findOrFail($id);
    
        // Hitung total quantity dari proposal
        $proposal->total_quantity = $proposal->proposalItems->sum(function ($item) {
            return (int) $item->quantity;
        });
    
        // Ambil semua donation item yang terkait proposal ini
        $donationItems = DonationItem::where('id_donation_proposal', $proposal->id)->get();
    
        // Hitung jumlah yang sudah didonasikan
        $proposal->donated_quantity = $donationItems->sum('quantity');
    
        // Hitung persentase
        $proposal->donation_percent = $proposal->total_quantity > 0
            ? round(($proposal->donated_quantity / $proposal->total_quantity) * 100)
            : 0;
    
        // Kelompokkan berdasarkan nama dan jumlahkan quantity-nya
        $donatedGroupedByName = $donationItems->groupBy('name')->map(fn ($items) => $items->sum('quantity'));

        // dd($proposal, $donationItems, $grouped);
        return view('pages.donatur.detailProposal', compact('proposal', 'donationItems', 'donatedGroupedByName'));
    }

    public function donasi($id)
    {
        // Ambil proposal beserta relasi
        $proposal = DonationProposal::with(['donationType', 'user', 'proposalItems'])->findOrFail($id);
    
        // Ambil semua donation item (barang yang sudah didonasikan)
        $donationItems = DonationItem::where('id_donation_proposal', $id)->get();
    
        // Kelompokkan berdasarkan nama dan jumlahkan quantity-nya
        $donatedGroupedByName = $donationItems->groupBy('name')->map(fn($items) => $items->sum('quantity'));
    
        // Ambil semua item kebutuhan dari proposal
        $proposalItems = ProposalItem::where('id_donation_proposal', $id)->get();
    
        // Hitung sisa kebutuhan (remaining_quantity) berdasarkan yang sudah didonasikan
        $proposalItemsUpdated = $proposalItems->map(function ($item) use ($donatedGroupedByName) {
            $donatedQty = $donatedGroupedByName[$item->name] ?? 0;
            $item->remaining_quantity = $item->quantity - $donatedQty;
            return $item;
        });
    
        // Ambil jasa pengiriman yang aktif
        $deliveryServices = DeliveryService::where('status', true)->get();
    
        // dd($proposal,
        //     $donationItems,
        //     $donatedGroupedByName,
        //     $proposalItemsUpdated,
        //     $deliveryServices);
        // Kirim ke view
        return view('pages.donatur.donasi', compact(
            'proposal',
            'donationItems',
            'donatedGroupedByName',
            'proposalItemsUpdated',
            'deliveryServices'
        ));
    }

    public function donasiStore(Request $request) {
        // dd($request);
        $validated = $request->validate([
            'id_profile' => 'required|exists:profiles,id',
            'id_donation_proposal' => 'required|exists:donation_proposals,id',
            'id_delivery_service' => 'required|exists:delivery_services,id',
            'tracking_number' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|exists:proposal_items,name',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['items'] as $item) {
            // Simpan setiap item donasi
            $donationItem = DonationItem::create([
                'id_profile' => $validated['id_profile'],
                'id_donation_proposal' => $validated['id_donation_proposal'],
                'name' => $item['name'], // jika 'name' menyimpan ID item
                'quantity' => $item['quantity'],
            ]);

            // Simpan pengiriman untuk setiap item
            Shipment::create([
                'id_donation_item' => $donationItem->id,
                'id_delivery_service' => $validated['id_delivery_service'],
                'tracking_number' => $validated['tracking_number'],
            ]);
        }

        return redirect()->route('donatur.index');
    }
    

    public function profile()
    {
        $id_user = auth()->id();
        $profile = Profile::where('id_user', $id_user)->first();
        // dd($profile);
        return view('pages.donatur.profile', ['profile' => $profile]);
    }

    public function pengiriman()
    {
        $id_user = auth()->id();

        $donationItems = DonationItem::with([
            'profile',
            'donationProposal.user',
            'shipment.deliveryService'
        ])->where('id_profile', $id_user)->get();
        
        $trackingData = [];
        
        // Loop semua item yang bisa dilacak
        foreach ($donationItems as $item) {
            $shipment = $item->shipment;
            $deliveryService = $shipment->deliveryService ?? null;
        
            if ($shipment && $deliveryService) {
                $courierCode = $deliveryService->code ?? null;
                $trackingNumber = $shipment->tracking_number ?? null;
            
                if ($courierCode && $trackingNumber) {
                    $response = Http::get('https://api.binderbyte.com/v1/track', [
                        'api_key' => env('BINDERBYTE_KEY'),
                        'courier' => $courierCode,
                        'awb' => $trackingNumber
                    ]);
                
                    if ($response->successful() && $response['status'] == 200) {
                        $trackingData[$item->id] = $response['data'];
                    }
                }
            }
        }

        // dd($courierCode, $trackingNumber, $trackingData);

        return view('pages.donatur.pengiriman', [
            'donationItems' => $donationItems,
            'trackingData' => $trackingData,
        ]);

    }
    
    public function detailPengiriman($id){
        return view('pages.donatur.detailPengiriman', ['id']);
    }
    
    
}
