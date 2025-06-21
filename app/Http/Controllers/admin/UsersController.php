<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index() {
        $users = User::with('profile')->get();
        return view('pages.admin.users.index', compact('users'));
    }

    public function create(){
        return view('pages.admin.users.tambah');
    }

    public function edit($id){
        $user = User::with('profile')->findOrFail($id);
        return view('pages.admin.users.edit', compact('user'));
    }

    public function store(Request $request){
        // Validasi data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'name.required' => 'Nama wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.required' => 'Silakan pilih peran Anda.',
        ]);
        

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
        ]);

        // Redirect atau login langsung
        return redirect()->route('admin.users')->with('success', 'Data User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,donatur,penerima',
            'email' => 'required|email',
        ]);

        // Ambil user dan profilnya
        $user = User::findOrFail($id);
        $profile = Profile::where('id_user', $id)->first();

        // Update user
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        // Update profile
        if ($profile) {
            $profile->name = $request->name;
            $profile->save();
        }

        return redirect()->route('admin.users')->with('success', 'Data User berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            $user = User::with('profile')->findOrFail($id);
            
            if ($user->profile) {
                $user->profile->delete();
            }

            $user->delete();

            return redirect()->route('admin.users')->with('success', 'Data User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')->with('failed', 'Gagal menghapus data. Mungkin data sedang digunakan di tempat lain.');
        }
    }
}
