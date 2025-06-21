@extends('layouts.admin')

@section('title', 'Edit User')

@section('active-menu-users', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<form method="POST" action="{{ route('admin.updateUser', $user->id) }}" class="p-4 border rounded shadow-sm bg-white">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ $user->profile->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" value="{{ $user->email }}" class="form-control" readonly>
    </div>

    <div class="mb-5">
        <label for="role" class="form-label d-block">Peran</label>
        <select name="role" id="role" class="form-select w-100" required>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="penerima" {{ $user->role === 'penerima' ? 'selected' : '' }}>Penerima</option>
            <option value="donatur" {{ $user->role === 'donatur' ? 'selected' : '' }}>Donatur</option>
        </select>
    </div>    

    <button type="submit" class="btn btn-primary w-100">Ubah</button>
</form>

                
@endsection

@section('custom_js')

@endsection