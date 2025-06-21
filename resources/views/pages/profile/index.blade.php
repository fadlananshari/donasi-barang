@extends('layouts.pages')

@section('title', 'Profil')

@section('active-menu-profile', 'active text-primary')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between pt-3 mb-4 border-bottom">
        <div class="">
            <h5 class="fw-bold m-0">
                @auth
                    {{ Auth::user()->name }}
                @endauth
            </h5>
            <p class="fw-semibold">
                @auth
                    {{ Auth::user()->email }}
                @endauth
            </p>
        </div>
        <div class="">
            <a href="#" class="btn btn-outline-primary">Edit profil</a>
        </div>

    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>    
</div>
@endsection

@section('custom_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('logout-form');
        form.addEventListener('submit', function(e) {
            console.log('Form submitted');
        });
    });
</script>
@endsection