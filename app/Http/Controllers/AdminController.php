<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardView() {
        return view('pages.admin.index');
    }

    public function userTableView() {
        $users = User::with('profile')->get();
        return view('pages.admin.users.index', compact('users'));
    }

    
}
