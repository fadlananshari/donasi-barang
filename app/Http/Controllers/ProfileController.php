<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editProfileView () {
        return view('pages.profile.editProfile');
    }

    public function edit () {
        
    }
}
