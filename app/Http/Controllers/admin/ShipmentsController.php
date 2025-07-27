<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ShipmentsController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with(['donationItem.profile', 'donationItem.donationProposal', 'deliveryService'])->get();
        // dd($shipments);
        return view('pages.admin.shipments.index', compact('shipments'));
    }

    public function read($id)
    {
        $shipment = Shipment::with(['donationItem.profile', 'donationItem.donationProposal', 'deliveryService'])
            ->findOrFail($id);

        $resi = $shipment->tracking_number;
        $courierCode = $shipment->deliveryService->code;

        $response = Http::get('https://api.binderbyte.com/v1/track', [
            'api_key' => env('BINDERBYTE_KEY'),
            'courier' => $courierCode,
            'awb' => $resi
        ]);

        $trackingData = null;

        if ($response->successful() && $response['status'] == 200) {
            $trackingData = $response['data'];
        }

        // dd($trackingData, $response, $courierCode, $resi, env('BINDERBYTE_KEY'));

        return view('pages.admin.shipments.detail', compact('shipment', 'trackingData'));
    }


}
