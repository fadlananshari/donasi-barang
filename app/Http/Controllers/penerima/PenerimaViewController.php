<?php

namespace App\Http\Controllers\penerima;

use App\Http\Controllers\Controller;
use App\Models\DeliveryService;
use App\Models\DonationItem;
use App\Models\DonationProposal;
use App\Models\DonationType;
use App\Models\ItemType;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PenerimaViewController extends Controller
{
    public function index(){
        return view('pages.penerima.index');
    }
    public function proposal()
    {
        $id_user = auth()->id();

        // Ambil profil user
        $profile = Profile::where('id_user', $id_user)->first();

        // Ambil proposal milik user yang status-nya true dan sudah dimuat relasinya
        $proposals = DonationProposal::with(['donationType', 'user', 'proposalItems'])
            ->where('id_profile', $profile->id)
            ->get();

        // Ambil semua donation item yang terkait dengan proposal tersebut
        $donations = DonationItem::whereIn('id_donation_proposal', $proposals->pluck('id'))->get();

        // Kelompokkan berdasarkan id_proposal
        $groupedDonations = $donations->groupBy('id_donation_proposal');

        foreach ($proposals as $proposal) {
            // Total kuantitas permintaan
            $proposal->total_quantity = $proposal->proposalItems->sum(function ($item) {
                return (int) $item->quantity;
            });

            // Total yang sudah didonasikan
            $donationItems = $groupedDonations->get($proposal->id, collect());
            $donatedQty = $donationItems->sum('quantity');

            $proposal->donated_quantity = $donatedQty;

            // Hitung persentase donasi
            $proposal->donation_percent = $proposal->total_quantity > 0
                ? round(($donatedQty / $proposal->total_quantity) * 100)
                : 0;
        }

        // Filter hanya proposal yang belum 100% dipenuhi
        $proposals = $proposals->filter(function ($proposal) {
            return $proposal->total_quantity != $proposal->donated_quantity;
        });

        return view('pages.penerima.proposal', compact('proposals'));
    }

    public function tambahProposal(){
        $donationTypes = DonationType::where('status', true)->get();
        $itemTypes = ItemType::where('status', true)->get();
        return view('pages.penerima.tambahProposal', compact('donationTypes', 'itemTypes'));
    }

    public function storeProposal(Request $request)
    {
        $validated = $request->validate([
            'id_profile' => 'required|exists:users,id',
            'id_donation_type' => 'required|exists:donation_types,id',
            'title' => 'required|string|max:255',
            'image_campaign' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image_letter' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'letter_number' => 'required|string|max:2048',
            'story' => 'required|string',
            'address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.detail' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // dd($request);

        DB::beginTransaction();
        try {
            // Simpan file gambar campaign
            if ($request->hasFile('image_campaign')) {
                $validated['image_campaign'] = $request->file('image_campaign')->store('img/proposal_images', 'public');
            }

            // Simpan file gambar surat
            if ($request->hasFile('image_letter')) {
                $validated['image_letter'] = $request->file('image_letter')->store('img/proposal_letters', 'public');
            }

            $items = $validated['items'];
            unset($validated['items']);

            $proposal = DonationProposal::create($validated);

            foreach ($items as $item) {
                $proposal->proposalItems()->create([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'detail' => $item['detail'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.proposals')->with('success', 'Proposal Donasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan proposal: ' . $e->getMessage()])->withInput();
        }
    }

    public function profile()
    {
        $id_user = auth()->id();
        $profile = Profile::where('id_user', $id_user)->first();
        // dd($profile);
        return view('pages.penerima.profile', ['profile' => $profile]);
    }

    public function editProfile() {
        $user = auth()->user();
        $profile = $user->profile; // pastikan relasi `profile()` sudah dibuat
    
        return view('pages.penerima.editProfile', compact('user', 'profile'));
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

        return redirect()->route('penerima.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function detailProposal($id){
        // Ambil proposal beserta relasi terkait
        $proposal = DonationProposal::with(['donationType', 'user', 'proposalItems'])->findOrFail($id);

        // Hitung total quantity dari proposal
        $proposal->total_quantity = $proposal->proposalItems->sum(function ($item) {
            return (int) $item->quantity;
        });
    
        // Ambil semua donation item yang terkait proposal ini
        $donationItems = DonationItem::with(['profile', 'shipment'])->where('id_donation_proposal', $proposal->id)->get();
    
        // Hitung jumlah yang sudah didonasikan
        $proposal->donated_quantity = $donationItems->sum('quantity');
    
        // Hitung persentase
        $proposal->donation_percent = $proposal->total_quantity > 0
            ? round(($proposal->donated_quantity / $proposal->total_quantity) * 100)
            : 0;
    
        // Kelompokkan berdasarkan nama dan jumlahkan quantity-nya
        $donatedGroupedByName = $donationItems->groupBy('name')->map(fn ($items) => $items->sum('quantity'));

        // dd($donationItems);

        // dd($proposal, $donationItems, $grouped);
        return view('pages.penerima.detailProposal', compact('proposal', 'donationItems', 'donatedGroupedByName'));
    }

    public function detailDonasi($id){
        $donationItem = DonationItem::with(['profile', 'shipment.deliveryService'])->findOrFail($id);

        $response = Http::get('https://api.binderbyte.com/v1/track', [
            'api_key' => env('BINDERBYTE_KEY'),
            'courier' => $donationItem->shipment->deliveryService->code,
            'awb' => $donationItem->shipment->tracking_number
        ]);

        $dataAPI = $response['data'];

        // dd($donationItem, $response['data']);
        return view('pages.penerima.detailDonasi', compact('donationItem', 'dataAPI'));
    }

    public function nonaktifStatus($id)
    {
        $proposal = DonationProposal::findOrFail($id);
        $proposal->status = 0;
        $proposal->save(); // jangan lupa simpan perubahan

        return redirect()->back()->with('success', 'Status proposal berhasil dinonaktifkan.');
    }

}
