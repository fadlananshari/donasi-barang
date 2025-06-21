<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);

        // Cek kredensial
        $credentials = $request->only('email', 'password');

        // Login (remember = true jika dicentang)
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $role = Auth::user()->role;

            // dd($role);
            if( $role == "donatur" ){

                return redirect('donatur');

            } elseif( $role == "penerima" ){
                
                return redirect('penerima');
                
            } elseif( $role == "admin" ){

                return redirect('admin');
                
            }
          
        }

        // Autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        // dd($request);
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:profiles,name', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'role' => ['required'],

        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'name.unique' => 'Nama ini sudah digunakan',
            'name.required' => 'Nama wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'role.required' => 'Silakan pilih peran Anda.',
        ]);
        
        // dd($request);

        // Buat user baru dan simpan
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Buat profil terkait user tersebut
        Profile::create([
            'id_user' => $user->id,
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'category' => $validated['role'],
        ]);

        // Redirect atau login langsung
        return redirect('/')->with('success', 'Pendaftaran berhasil, silakan masuk.');
    }
}
