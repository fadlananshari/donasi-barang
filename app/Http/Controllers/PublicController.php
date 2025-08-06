<?php

namespace App\Http\Controllers;

use App\Models\DonationItem;
use App\Models\DonationProposal;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
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

        return view('index', compact('proposals'));
    }
}
