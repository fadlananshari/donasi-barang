<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryService;
use App\Models\DonationItem;
use App\Models\Profile;
use App\Models\DonationProposal;
use App\Models\ProposalItem;
use App\Models\Shipment;
use Illuminate\Http\Request;

class DonationItemsController extends Controller
{
    public function index()
    {
        $donationItems = DonationItem::with(['profile', 'donationProposal', 'shipment.deliveryService'])->get();
        return view('pages.admin.donationItems.index', compact('donationItems'));
    }

    public function create($id)
    {
        $proposal = DonationProposal::findOrFail($id);
        $items = ProposalItem::where('id_donation_proposal', $id)->get();
        $deliveryServices = DeliveryService::where('status', true)->get();
        // dd($items);
        return view('pages.admin.donationItems.tambah', compact( 'proposal', 'items', 'deliveryServices'));
    }

    public function edit($id)
    {
        $donationItem = DonationItem::findOrFail($id);
        $profiles = Profile::all();
        $proposals = DonationProposal::all();
        return view('pages.admin.donationItems.edit', compact('donationItem', 'profiles', 'proposals'));
    }

    public function store(Request $request)
    {

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

        return redirect()->route('admin.donationItems')->with('success', 'Data Barang Donasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_profile' => 'required|exists:profiles,id',
            'id_donation_proposal' => 'required|exists:donation_proposals,id',
            'quantity' => 'required|integer|min:1',
            'detail' => 'nullable|string',
        ]);

        $donationItem = DonationItem::findOrFail($id);
        $donationItem->update($validated);

        return redirect()->route('admin.donationItems')->with('success', 'Data Barang Donasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $donationItem = DonationItem::findOrFail($id);
            $donationItem->delete();

            return redirect()->route('admin.donationItems')->with('success', 'Data Barang Donasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.donationItems')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }
}
