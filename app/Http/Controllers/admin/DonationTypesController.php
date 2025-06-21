<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DonationType;
use Illuminate\Http\Request;

class DonationTypesController extends Controller
{
    public function index() {
        $donationTypes = DonationType::all();
        return view('pages.admin.donationTypes.index', compact('donationTypes'));
    }

    public function create(){
        return view('pages.admin.donationTypes.tambah');
    }

    public function edit($id)
    {
        $donationType = DonationType::findOrFail($id);
        return view('pages.admin.itemtypes.edit', compact('donationType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
        ]);
    
        DonationType::create($validated);
    
        return redirect()->route('admin.donationTypes')->with('success', 'Data Jenis Donasi berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);
        
        $donationType = DonationType::findOrFail($id);

        $donationType->update($validated);

        return redirect()->route('admin.donationTypes')->with('success', 'Data Jenis Donasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $donationType = DonationType::findOrFail($id);
            $donationType->delete();

            return redirect()->route('admin.donationTypes')->with('success', 'Data Jenis Donasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.donationTypes')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }
}
