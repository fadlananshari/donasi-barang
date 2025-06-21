<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homeView() {
        $itemTypes = ItemType::where('status', true)->get();
        return view('pages.penerima.index', compact('itemTypes'));
    }

    public function loginView() {
        return view('auth.login');
    }

    public function signinView() {
        return view('auth.signin');
    }

    public function galangBarangView () {
        return view('pages.galangBarang');
    }

    public function donasiView () {
        return view('pages.donasi.index');
    }

    public function pengirimanView () {
        return view('pages.pengiriman');
    }

    public function profileView() {
        return view('pages.profile.index');
    }
}
