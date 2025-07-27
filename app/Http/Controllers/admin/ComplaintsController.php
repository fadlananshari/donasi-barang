<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Complaints;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    public function index()
    {
        $complaints = Complaints::with(['profile', 'proposal'])->latest()->get();

        // dd($complaints);
        return view('pages.admin.complaints.index', compact('complaints'));
    }

    public function show($id) {
        $complaint = Complaints::findOrFail($id)->with(['profile', 'proposal'])->first();
        // dd($complaint);

        return view('pages.admin.complaints.detail', compact('complaint'));
    }
}
