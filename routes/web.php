<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;

/*  
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// ROUTE GUEST / HOME
Route::get('/', [HomeController::class, 'home'])->name('home');

// ROUTE MIDDLEWARE VERIFIKASI EMAIL
Route::middleware(['verifieduser'])->group(function () {
    Route::get('/verify-account', [HomeController::class, 'verifyaccount'])->name('verifyaccount');
    Route::post('/verify-account', [HomeController::class, 'useractivation'])->name('verifyotp');
    Route::get('/resend-verify', [HomeController::class, 'resendotp'])->name('resendotp');
    Route::post('/resend-verify', [HomeController::class, 'resendotpaction'])->name('resendotpaction');
});

// ROUTE MIDDLEWARE DASHBOARD
Route::middleware(['auth', 'activated'])->group(function () {
    // AUTH ROUTE
    Route::get('/dashboard', [AuthController::class, 'dashindex'])->name('main.dashboard');
    Route::get('/dashboard/team-setting', [AuthController::class, 'teamSetting'])->name('team-setting');
    Route::post('/dashboard/team-setting', [AuthController::class, 'EditTeamSetting'])->name('EditTeamSetting');
    Route::post('/dashboard/member-setting/{id}/update', [AuthController::class, 'updateMember'])->name('updateMember');
    Route::get('/dashboard/member-setting/{id?}', [AuthController::class, 'editMember'])->name('editMember');
    Route::get('/dashboard/informasi', [AuthController::class, 'informasi'])->name('informasi');
    Route::get('/dashboard/buku-panduan', [AuthController::class, 'bukuPanduan'])->name('bukuPanduan');
    // Route::get('/dashboard/galeri-media', [AuthController::class, 'galeriMedia'])->name('galeriMedia');
    Route::get('/dashboard/rekapan-nilai', [AuthController::class, 'rekapanNilai'])->name('rekapanNilai');

    Route::group(['middleware' => 'admin'], function(){
        Route::get('/dashboard/create-informasi', [AdminController::class, 'createInformasi'])->name('infoCreate');
        Route::post('/dashboard/create-informasi', [AdminController::class, 'storeCreateInformasi'])->name('infoStore');
        Route::get('/dashboard/data-peserta', [AdminController::class, 'datapeserta'])->name('data-peserta');
        Route::get('/dashboard/data-team', [AdminController::class, 'datateam'])->name('data-team');
        Route::post('/dashboard/data-team', [AdminController::class, 'teamverify'])->name('teamverify');
        Route::get('/dashboard/rekapnilai-setting', [AdminController::class, 'rekapnilaisetting'])->name('rekapnilaisetting');
        Route::post('/dashboard/updatenilaipbb', [AdminController::class, 'updatenilaipbb'])->name('updatenilaipbb');
        Route::post('/dashboard/updatenilaivariasi', [AdminController::class, 'updatenilaivariasi'])->name('updatenilaivariasi');
        Route::post('/dashboard/updatenilaiformasi', [AdminController::class, 'updatenilaiformasi'])->name('updatenilaiformasi');
        Route::post('/dashboard/updatenilaigertam', [AdminController::class, 'updatenilaigertam'])->name('updatenilaigertam');
        Route::post('/dashboard/updatenilaidanpas', [AdminController::class, 'updatenilaidanpas'])->name('updatenilaidanpas');
        Route::post('/dashboard/updatenilaipasukan', [AdminController::class, 'updatenilaipasukan'])->name('updatenilaipasukan');
        Route::post('/dashboard/updatenilaikostum', [AdminController::class, 'updatenilaikostum'])->name('updatenilaikostum');
        Route::post('/dashboard/unlocknilai', [AdminController::class, 'unlocknilai'])->name('unlocknilai');
    });
    
});

// authenticate
Route::get('/userops', [LoginController::class, 'userops'])->name('userops')->Middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'LoginAccount'])->name('LoginAccount');
Route::post('/logout', [LoginController::class, 'LogoutAccount'])->name('LogoutAccount');

Route::get('/daftar-akun', [RegisterController::class, 'index'])->name('index')->Middleware('guest');
Route::post('/daftar-akun', [RegisterController::class, 'CreateAccount'])->name('CreateAccount');
Route::get('/daftar-team', [RegisterController::class, 'registeamindex'])->name('registeamindex')->Middleware('guest');
Route::post('/daftar-team', [RegisterController::class, 'registeamadd'])->name('registeamadd');


// TESgertam
Route::view('/mt', 'maintenance');
