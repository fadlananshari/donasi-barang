<?php

namespace App\Http\Controllers\donatur;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use App\Models\DeliveryService;
use App\Models\DonationItem;
use App\Models\DonationProposal;
use App\Models\DonationType;
use App\Models\Profile;
use App\Models\ProposalItem;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class DonaturViewController extends Controller
{
    public function index() {
        
        // Ambil query awal
        $query = DonationProposal::with(['donationType', 'user', 'proposalItems'])
            ->where('status', true)->latest()->take(5);

        // Ambil hasil
        $proposals = $query->get();

        // Ambil semua donation item terkait proposal
        $donations = DonationItem::whereIn('id_donation_proposal', $proposals->pluck('id'))->get();
        $groupedDonations = $donations->groupBy('id_donation_proposal');

        // Hitung statistik per proposal
        foreach ($proposals as $proposal) {
            $proposal->total_quantity = $proposal->proposalItems->sum(fn($item) => (int) $item->quantity);
            $donationItems = $groupedDonations->get($proposal->id, collect());
            $proposal->donated_quantity = $donationItems->sum('quantity');
            $proposal->donation_percent = $proposal->total_quantity > 0
                ? round(($proposal->donated_quantity / $proposal->total_quantity) * 100)
                : 0;
        }

        // Hanya tampilkan proposal yang belum full donasi
        $proposals = $proposals->filter(fn($p) => $p->total_quantity != $p->donated_quantity);

        return view('pages.donatur.index', compact('proposals'));
    }


    public function proposal(Request $request)
    {
        // Validasi dan bersihkan input
        $search = trim($request->input('search'));
        $type = $request->input('type');
    
        // Ambil semua jenis donasi aktif terlebih dahulu (untuk filter)
        $donationType = DonationType::where('status', 1)->get(['id', 'name']);
    
        // Ambil proposal aktif + relasi penting
        $query = DonationProposal::with(['donationType:id,name', 'user:id,name', 'proposalItems:id,id_donation_proposal,quantity'])
            ->where('status', true);
    
        // Pencarian berdasarkan judul proposal atau nama user
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }
    
        // Filter berdasarkan jenis donasi (donation type)
        if (!empty($type)) {
            $query->where('id_donation_type', $type);
        }
    
        // Ambil data proposals
        $proposals = $query->get();
    
        if ($proposals->isEmpty()) {
            return view('pages.donatur.proposal', [
                'proposals' => collect(),
                'donationType' => $donationType
            ]);
        }
    
        // Ambil semua DonationItem hanya untuk proposal yang ditemukan
        $donations = DonationItem::select('id_donation_proposal', 'quantity')
            ->whereIn('id_donation_proposal', $proposals->pluck('id'))
            ->get()
            ->groupBy('id_donation_proposal');
    
        // Optimasi perhitungan donasi
        $proposals = $proposals->map(function ($proposal) use ($donations) {
            $proposal->total_quantity = $proposal->proposalItems->sum(fn($item) => (int) $item->quantity);
    
            $donated_quantity = $donations->get($proposal->id)?->sum('quantity') ?? 0;
            $proposal->donated_quantity = $donated_quantity;
    
            $proposal->donation_percent = $proposal->total_quantity > 0
                ? round(($donated_quantity / $proposal->total_quantity) * 100)
                : 0;
    
            return $proposal;
        })->filter(fn($p) => $p->donated_quantity < $p->total_quantity);
    
        return view('pages.donatur.proposal', compact('proposals', 'donationType'));
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

    public function donasi($id){

        $profile = Profile::where('id_user', Auth::user()->id)->firstOrFail();

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

        // dd($proposal);
        return view('pages.donatur.donasi', compact(
            'proposal',
            'donationItems',
            'donatedGroupedByName',
            'proposalItemsUpdated',
            'deliveryServices',
            'profile'
        ));
    }

    public function donasiStore(Request $request) {
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

        // dd($request);

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
        $profile = Profile::where('id_user', Auth::id())->firstOrFail();
    
        $donationItems = DonationItem::with([
            'profile',
            'donationProposal.user',
            'shipment.deliveryService'
        ])->where('id_profile', $profile->id)->get();
    
        $trackingData = [];
    
        foreach ($donationItems as $item) {
            $shipment = $item->shipment;
            $deliveryService = $shipment->deliveryService ?? null;
    
            if ($shipment && $deliveryService) {
                $courierCode = $deliveryService->code ?? null;
                $trackingNumber = $shipment->tracking_number ?? null;
    
                if ($courierCode && $trackingNumber) {
                    $cacheKey = "tracking_{$courierCode}_{$trackingNumber}";
    
                    $trackingData[$item->id] = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($courierCode, $trackingNumber) {
                        $response = Http::get('https://api.binderbyte.com/v1/track', [
                            'api_key' => env('BINDERBYTE_KEY'),
                            'courier' => $courierCode,
                            'awb' => $trackingNumber
                        ]);
    
                        return ($response->successful() && $response['status'] == 200)
                            ? $response['data']
                            : null;
                    });
                }
            }
        }
    
        return view('pages.donatur.pengiriman', [
            'donationItems' => $donationItems,
            'trackingData' => $trackingData,
        ]);
    }
    
    public function detailPengiriman($id){
        $donationItem = DonationItem::with(['profile', 'shipment.deliveryService'])->findOrFail($id);

        $response = Http::get('https://api.binderbyte.com/v1/track', [
            'api_key' => env('BINDERBYTE_KEY'),
            'courier' => $donationItem->shipment->deliveryService->code,
            'awb' => $donationItem->shipment->tracking_number
        ]);

        $dataAPI = $response['data'];

        // dd($donationItem, $response['data']);
        return view('pages.donatur.detailPengiriman', compact('donationItem', 'dataAPI'));
    }

    public function laporan($id){
        $profile = Profile::where('id_user', auth()->id())->first();
        $proposal = DonationProposal::with(['donationType', 'user', 'proposalItems'])->findOrFail($id);
        // dd($id, $profile, $proposal);

        return view('pages.donatur.laporan', ['id'=>$id, 'profile'=>$profile, 'proposal'=>$proposal]);
    }

    public function laporanStore(Request $request) {
        // dd($request);
        // Validasi input
        $request->validate([
            'id_donation_proposal' => 'required|exists:donation_proposals,id', // sesuaikan dengan tabel proposal
            'id_profile' => 'required|exists:profiles,id', // sesuaikan juga jika nama tabel berbeda
            'reason' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // Simpan gambar ke storage
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('laporan_bukti', 'public'); // disimpan di storage/app/public/laporan_bukti
        }

        // Simpan ke database
        Complaints::create([
            'id_donation_proposal' => $request->id_donation_proposal,
            'id_profile' => $request->id_profile,
            'reason' => $request->reason,
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('donatur.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function editProfile() {
        $user = auth()->user();
        $profile = $user->profile; // pastikan relasi `profile()` sudah dibuat
    
        return view('pages.donatur.editProfile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $request->validate([
            'name' => 'required|string|max:255|unique:profiles,name,' . $profile->id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $profile->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('donatur.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    
}
