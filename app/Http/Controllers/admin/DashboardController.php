<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use App\Models\DonationItem;
use App\Models\DonationProposal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardView() {
        $jumlahProposal = DonationProposal::count();
        $jumlahUser = User::count();
        $jumlahDonasi = DonationItem::count();
        $jumlahKomplain = Complaints::count();

        // Ambil tahun saat ini
        $year = Carbon::now()->year;

        // Ambil jumlah proposal donasi per bulan
        $proposalData = DonationProposal::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // Siapkan array 12 bulan (default 0)
        $chartDataProposal = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataProposal[] = $proposalData[$i] ?? 0;
        }

        // Ambil jumlah donasi per bulan
        $donationItem = DonationItem::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // Siapkan array 12 bulan (default 0)
        $chartDataDonasi = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataDonasi[] = $donationItem[$i] ?? 0;
        }

        // Ambil jumlah user per bulan
        $user = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // Siapkan array 12 bulan (default 0)
        $chartDataUser = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataUser[] = $user[$i] ?? 0;
        }

         // Ambil jumlah komplain per bulan
         $komplain = Complaints::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // Siapkan array 12 bulan (default 0)
        $chartDataKomplain = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartDataKomplain[] = $komplain[$i] ?? 0;
        }

        // dd($chartDataProposal, $chartDataDonasi);

        return view('pages.admin.index', compact(
            'jumlahProposal',
            'jumlahUser',
            'jumlahDonasi',
            'jumlahKomplain',
            'chartDataProposal',
            'chartDataDonasi',
            'chartDataUser',
            'chartDataKomplain'
        ));               
    }
    
}
