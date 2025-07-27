<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypesController extends Controller
{
    public function index() {
        $itemTypes = ItemType::all();
        return view('pages.admin.itemTypes.index', compact('itemTypes'));
    }

    public function create(){
        return view('pages.admin.itemTypes.tambah');
    }

    public function edit($id)
    {
        $itemType = ItemType::findOrFail($id);
        return view('pages.admin.itemtypes.edit', compact('itemType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
        ]);
    
        ItemType::create($validated);
    
        return redirect()->route('admin.itemTypes')->with('success', 'Data Jenis Donasi berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);
        
        $itemType = ItemType::findOrFail($id);

        $itemType->update($validated);

        return redirect()->route('admin.itemTypes')->with('success', 'Data Jenis Donasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $itemType = ItemType::findOrFail($id);
            $itemType->delete();

            return redirect()->route('admin.itemTypes')->with('success', 'Data Jenis Donasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.itemTypes')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }
}
