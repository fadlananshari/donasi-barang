<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DonationProposal;
use App\Models\DonationType;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DonationProposalsController extends Controller
{
    public function index()
    {
        $proposals = DonationProposal::with(['donationType', 'user', 'proposalItems'])->get();
        // dd($proposals);
        return view('pages.admin.proposals.index', compact('proposals'));
    }

    public function create()
    {
        $donationTypes = DonationType::where('status', true)->get();
        $itemTypes = ItemType::where('status', true)->get();
        return view('pages.admin.proposals.tambah', compact('donationTypes', 'itemTypes'));
    }

    public function store(Request $request)
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

    public function edit($id) {
        $proposal = DonationProposal::with(['donationType', 'user', 'proposalItems'])->findOrFail($id);
        $donationTypes = DonationType::all();
        $itemTypes = ItemType::all(); // jenis barang

        // dd($proposal);
    
        return view('pages.admin.proposals.edit', compact('proposal', 'donationTypes', 'itemTypes'));
    }
    

    public function update(Request $request, $id)
    {
        $proposal = DonationProposal::with('proposalItems')->findOrFail($id);
    
        $validated = $request->validate([
            'id_profile' => 'required|exists:users,id',
            'id_donation_type' => 'required|exists:donation_types,id',
            'title' => 'required|string|max:255',
            'image_campaign' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_letter' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'letter_number' => 'required|string|max:2048',
            'story' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|boolean',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.detail' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
    
        DB::beginTransaction();
        try {
            // Ganti gambar campaign jika ada file baru
            if ($request->hasFile('image_campaign')) {
                if ($proposal->image_campaign && Storage::disk('public')->exists($proposal->image_campaign)) {
                    Storage::disk('public')->delete($proposal->image_campaign);
                }
                $validated['image_campaign'] = $request->file('image_campaign')->store('img/proposal_images', 'public');
            }
    
            // Ganti gambar surat jika ada file baru
            if ($request->hasFile('image_letter')) {
                if ($proposal->image_letter && Storage::disk('public')->exists($proposal->image_letter)) {
                    Storage::disk('public')->delete($proposal->image_letter);
                }
                $validated['image_letter'] = $request->file('image_letter')->store('img/proposal_letters', 'public');
            }
    
            $items = $validated['items'];
            unset($validated['items']);
    
            // Update proposal utama
            $proposal->update($validated);
    
            // Hapus semua item lama, lalu insert ulang
            $proposal->proposalItems()->delete();
            foreach ($items as $item) {
                $proposal->proposalItems()->create([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'detail' => $item['detail'] ?? null,
                ]);
            }
    
            DB::commit();
            return redirect()->route('admin.proposals')->with('success', 'Proposal Donasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui proposal: ' . $e->getMessage()])->withInput();
        }
    }
    

    public function destroy($id)
    {
        try {
            $proposal = DonationProposal::findOrFail($id);

            $image_campaign = $proposal->image_campaign;
            $image_letter = $proposal->image_letter;

            // Hapus data dari database
            $proposal->delete();
    
            // Hapus file image_campaign jika ada
            if ($image_campaign && Storage::disk('public')->exists($image_campaign)) {
                Storage::disk('public')->delete($image_campaign);
            }
    
            // Hapus file image_letter jika ada
            if ($image_letter && Storage::disk('public')->exists($image_letter)) {
                Storage::disk('public')->delete($image_letter);
            }
    
            return redirect()->route('admin.proposals')->with('success', 'Data Proposal Donasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.proposals')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }
}