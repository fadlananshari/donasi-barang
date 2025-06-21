<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryService;
use Illuminate\Http\Request;

class DeliveryServicesController extends Controller
{
    public function index() 
    {
        $deliveryServices = DeliveryService::all();
        return view('pages.admin.deliveryServices.index', compact('deliveryServices'));
    }

    public function create(){
        return view('pages.admin.deliveryServices.tambah');
    }

    public function edit($id)
    {
        $deliveryService = DeliveryService::findOrFail($id);
        return view('pages.admin.deliveryServices.edit', compact('deliveryService'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:delivery_services,code',
        ]);

        DeliveryService::create($validated);

        return redirect()->route('admin.deliveryServices')->with('success', 'Data Ekspedisi berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:delivery_services,code,' . $id,
            'status' => 'required|boolean',
        ]);

        $deliveryService = DeliveryService::findOrFail($id);

        $deliveryService->update($validated);

        return redirect()->route('admin.deliveryServices')->with('success', 'Data Ekspedisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $itemType = DeliveryService::findOrFail($id);
            $itemType->delete();

            return redirect()->route('admin.deliveryService')->with('success', 'Data Jenis Ekspedisi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.deliveryService')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }

}
