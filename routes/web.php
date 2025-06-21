<?php

use App\Http\Controllers\admin\DeliveryServicesController;
use App\Http\Controllers\admin\DonationItemsController;
use App\Http\Controllers\admin\DonationProposalsController;
use App\Http\Controllers\admin\DonationTypesController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\donatur\DonaturViewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\ShipmentsController;
use Illuminate\Support\Facades\Route;

// Route login (hanya bisa diakses jika belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function(){
        return redirect('/');
    });

    Route::get('/welcome', function(){
        return view('welcome');
    });
    Route::get('/', [HomeController::class, 'loginView'])->name('login');
    Route::get("/signin", [HomeController::class, 'signinView'])->name('home.signin');

    Route::post('/', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Private route (semua butuh login)
Route::middleware(['auth'])->group(function () {
    // ADMIN PAGES
    Route::get('/admin', [AdminController::class, 'dashboardView'])->middleware('userAccess:admin')->name('admin.dashboard');

    Route::get('/admin/users', [UsersController::class, 'index'])->middleware('userAccess:admin')->name('admin.users');
    Route::get('/admin/users/tambah', [UsersController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahUser');
    Route::get('/admin/users/{id}', [UsersController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editUser');
    Route::post('/admin/users/tambah', [UsersController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeUser');
    Route::post('/admin/users/update/{id}', [UsersController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateUser');
    Route::post('/admin/users/delete/{id}', [UsersController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteUser');

    Route::get('/admin/delivery-services', [DeliveryServicesController::class, 'index'])->middleware('userAccess:admin')->name('admin.deliveryServices');
    Route::get('/admin/delivery-services/tambah', [DeliveryServicesController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahDeliveryService');
    Route::get('/admin/delivery-services/{id}', [DeliveryServicesController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editDeliveryService');
    Route::post('/admin/delivery-services/tambah', [DeliveryServicesController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeDeliveryService');
    Route::post('/admin/delivery-services/update/{id}', [DeliveryServicesController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateDeliveryService');
    Route::post('/admin/delivery-services/delete/{id}', [DeliveryServicesController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteDeliveryService');

    Route::get('/admin/donation-types', [DonationTypesController::class, 'index'])->middleware('userAccess:admin')->name('admin.donationTypes');
    Route::get('/admin/donation-types/tambah', [DonationTypesController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahDonationType');
    Route::get('/admin/donation-types/{id}', [DonationTypesController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editDonationType');
    Route::post('/admin/donation-types/tambah', [DonationTypesController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeDonationType');
    Route::post('/admin/donation-types/update/{id}', [DonationTypesController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateDonationType');
    Route::post('/admin/donation-types/delete/{id}', [DonationTypesController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteDonationType');

    Route::get('/admin/donation-proposals', [DonationProposalsController::class, 'index'])->middleware('userAccess:admin')->name('admin.proposals');
    Route::get('/admin/donation-proposals/tambah', [DonationProposalsController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahProposal');
    Route::get('/admin/donation-proposals/{id}', [DonationProposalsController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editProposal');
    Route::post('/admin/donation-proposals/tambah', [DonationProposalsController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeProposal');
    Route::post('/admin/donation-propisals/update/{id}', [DonationProposalsController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateProposal');
    Route::post('/admin/donation-proposals/delete/{id}', [DonationProposalsController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteProposal');

    Route::get('/admin/donation-items', [DonationItemsController::class, 'index'])->middleware('userAccess:admin')->name('admin.donationItems');
    Route::get('/admin/donation-items/tambah', [DonationItemsController::class, 'create1'])->middleware('userAccess:admin')->name('admin.tambahDonationItem');
    Route::get('/admin/donation-items/tambah/{id}', [DonationItemsController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahDonationItems');
    Route::get('/admin/donation-items/{id}', [DonationItemsController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editDonationItem');
    Route::post('/admin/donation-items/tambah', [DonationItemsController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeDonationItem');
    Route::post('/admin/donation-items/update/{id}', [DonationItemsController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateDonationItem');
    Route::post('/admin/donation-items/delete/{id}', [DonationItemsController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteDonationItem');

    Route::get('/admin/shipments', [ShipmentsController::class, 'index'])->middleware('userAccess:admin')->name('admin.shipments');
    Route::get('/admin/shipment/{id}', [ShipmentsController::class, 'read'])->middleware('userAccess:admin')->name('admin.detailShipment');

    // DONATUR PAGES
    Route::get('/donatur', [DonaturViewController::class, 'index'])->middleware('userAccess:donatur')->name('donatur.index');
    Route::get('/donatur/profil', [DonaturViewController::class, 'profile'])->name('donatur.profile');
    Route::get('/donatur/pengiriman', [DonaturViewController::class, 'pengiriman'])->middleware('userAccess:donatur')->name('donatur.pengiriman');
    Route::get('/donatur/pengiriman/{id}', [DonaturViewController::class, 'detailPengiriman'])->middleware('userAccess:donatur')->name('donatur.detailPengiriman');
    Route::get('/donatur/{id}', [DonaturViewController::class, 'detailProposal'])->middleware('userAccess:donatur');
    Route::get('/donatur/{id}/donasi', [DonaturViewController::class, 'donasi'])->middleware('userAccess:donatur')->name('donatur.donasi');
    Route::post('/donatur/donasi', [DonaturViewController::class, 'donasiStore'])->middleware('userAccess:donatur')->name('donatur.donasiStore');
    Route::get('/donatur/profil/edit', [DonaturViewController::class, 'editProfileView']);

    Route::get('/donasi', [HomeController::class, 'donasiView']);

    // PENERIMA PAGES
    Route::get('/penerima/home', [HomeController::class, 'homeView'])->middleware('userAccess:penerima');
    Route::get('/penerima/galang-barang', [HomeController::class, 'galangBarangView']);
    Route::get('/penerima/pengiriman', [HomeController::class, 'pengirimanView']);    
    Route::get('/penerima/profil', [HomeController::class, 'profileView']);
    Route::get('/penerima/profil/edit', [ProfileController::class, 'editProfileView']);


    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    
});

Route::fallback(function () {
    return response()->json(['message' => 'Route fallback!']);
});
