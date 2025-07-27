<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use App\Models\DonationItem;
use App\Models\DonationProposal;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardView() {
        $jumlahProposal = DonationProposal::count();
        $jumlahUser = User::count();
        $jumlahDonasi = DonationItem::count();
        $jumlahKomplain = Complaints::count();

        return view('pages.admin.index', compact(
            'jumlahProposal',
            'jumlahUser',
            'jumlahDonasi',
            'jumlahKomplain'
        ));               
    }
    
}
