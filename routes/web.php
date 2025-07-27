<?php

use App\Http\Controllers\admin\ComplaintsController;
use App\Http\Controllers\admin\DeliveryServicesController;
use App\Http\Controllers\admin\DonationItemsController;
use App\Http\Controllers\admin\DonationProposalsController;
use App\Http\Controllers\admin\DonationTypesController;
use App\Http\Controllers\admin\ItemTypesController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\donatur\DonaturViewController;
use App\Http\Controllers\penerima\PenerimaViewController;
use App\Http\Controllers\admin\ShipmentsController;
use Illuminate\Support\Facades\Route;

// Route login (hanya bisa diakses jika belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function(){
        return redirect('/');
    });
    Route::get('/', [AuthController::class, 'loginView'])->name('login');
    Route::get("/signup", [AuthController::class, 'signupView'])->name('home.signin');

    Route::post('/', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Private route (semua butuh login)
Route::middleware(['auth'])->group(function () {
    // ADMIN PAGES
    Route::get('/admin', [DashboardController::class, 'dashboardView'])->middleware('userAccess:admin')->name('admin.dashboard');

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
    
    Route::get('/admin/item-types', [ItemTypesController::class, 'index'])->middleware('userAccess:admin')->name('admin.itemTypes');
    Route::get('/admin/item-types/tambah', [ItemTypesController::class, 'create'])->middleware('userAccess:admin')->name('admin.tambahItemType');
    Route::get('/admin/item-types/{id}', [ItemTypesController::class, 'edit'])->middleware('userAccess:admin')->name('admin.editItemType');
    Route::post('/admin/item-types/tambah', [ItemTypesController::class, 'store'])->middleware('userAccess:admin')->name('admin.storeItemType');
    Route::post('/admin/item-types/update/{id}', [ItemTypesController::class, 'update'])->middleware('userAccess:admin')->name('admin.updateItemType');
    Route::post('/admin/item-types/delete/{id}', [ItemTypesController::class, 'destroy'])->middleware('userAccess:admin')->name('admin.deleteItemType');

    Route::get('/admin/complaints', [ComplaintsController::class, 'index'])->middleware('userAccess:admin')->name('admin.complaints');
    Route::get('/admin/complaints/{id}', [ComplaintsController::class, 'show'])->middleware('userAccess:admin')->name('admin.detailComplaints');

    Route::get('/admin/shipments', [ShipmentsController::class, 'index'])->middleware('userAccess:admin')->name('admin.shipments');
    Route::get('/admin/shipment/{id}', [ShipmentsController::class, 'read'])->middleware('userAccess:admin')->name('admin.detailShipment');

    // DONATUR PAGES
    Route::get('/donatur', [DonaturViewController::class, 'index'])->middleware('userAccess:donatur')->name('donatur.index');
    Route::get('/donatur/proposal', [DonaturViewController::class, 'proposal'])->middleware('userAccess:donatur')->name('donatur.proposal');
    Route::get('/donatur/profil', [DonaturViewController::class, 'profile'])->middleware('userAccess:donatur')->name('donatur.profile');
    Route::get('/donatur/profil/edit', [DonaturViewController::class, 'editProfile'])->middleware('userAccess:donatur')->name('donatur.editProfile');
    Route::post('/donatur/profil/update', [DonaturViewController::class, 'updateProfile'])->middleware('userAccess:donatur')->name('donatur.updateProfile');
    Route::get('/donatur/pengiriman', [DonaturViewController::class, 'pengiriman'])->middleware('userAccess:donatur')->name('donatur.pengiriman');
    Route::get('/donatur/pengiriman/{id}', [DonaturViewController::class, 'detailPengiriman'])->middleware('userAccess:donatur')->name('donatur.detailPengiriman');
    Route::get('/donatur/proposal/{id}', [DonaturViewController::class, 'detailProposal'])->middleware('userAccess:donatur')->name('donatur.detailProposal');
    Route::get('/donatur/proposal/{id}/lapor', [DonaturViewController::class, 'laporan'])->middleware('userAccess:donatur')->name('donatur.lapor');
    Route::post('/donatur/proposal/{id}/lapor', [DonaturViewController::class, 'laporanStore'])->middleware('userAccess:donatur')->name('donatur.storeLaporan');
    Route::get('/donatur/proposal/{id}/donasi', [DonaturViewController::class, 'donasi'])->middleware('userAccess:donatur')->name('donatur.donasi');
    Route::post('/donatur/donasi', [DonaturViewController::class, 'donasiStore'])->middleware('userAccess:donatur')->name('donatur.donasiStore');

    // PENERIMA PAGES
    Route::get('/penerima', [PenerimaViewController::class, 'index'])->middleware('userAccess:penerima')->name('penerima.index');
    Route::get('/penerima/proposal', [PenerimaViewController::class, 'proposal'])->middleware('userAccess:penerima')->name('penerima.proposal');   
    Route::get('/penerima/proposal/tambah', [PenerimaViewController::class, 'tambahProposal'])->middleware('userAccess:penerima')->name('penerima.tambahProposal');   
    Route::post('/penerima/proposal/tambah', [PenerimaViewController::class, 'storeProposal'])->middleware('userAccess:penerima')->name('penerima.storeProposal');   
    Route::get('/penerima/profil', [PenerimaViewController::class, 'profile'])->middleware('userAccess:penerima')->name('penerima.profile');
    Route::get('/penerima/profil/edit', [PenerimaViewController::class, 'editProfile'])->middleware('userAccess:penerima')->name('penerima.editProfile');
    Route::post('/penerima/profil/update', [PenerimaViewController::class, 'updateProfile'])->middleware('userAccess:penerima')->name('penerima.updateProfile');
    Route::get('/penerima/detail-donasi/{id}', [PenerimaViewController::class, 'detailDonasi'])->middleware('userAccess:penerima')->name('penerima.detailDonasi');
    Route::get('/penerima/proposal/{id}', [PenerimaViewController::class, 'detailProposal'])->middleware('userAccess:penerima')->name('penerima.detailProposal');
    Route::post('/penerima/proposal/{id}', [PenerimaViewController::class, 'nonaktifStatus'])->middleware('userAccess:penerima')->name('penerima.nonaktifStatus');


    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    
});