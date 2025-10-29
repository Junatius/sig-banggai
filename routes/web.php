<?php

use App\Http\Controllers\AttractionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubdistrictController;
use App\Http\Controllers\TouristController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WisataController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===========================
// FRONTEND ROUTES (Public)
// ===========================
Route::get('/', [SubdistrictController::class, 'homepage'])->name('home');

Route::get('/objek-wisata', [AttractionController::class, 'index'])->name('objek-wisata.index');
Route::get('/objek-wisata/{attraction}', [AttractionController::class, 'show_user'])
    ->name('objek-wisata.show');
Route::get('/berita', [BeritaController::class, 'index'])->name('news.index');
Route::get('/berita/{id}', [BeritaController::class, 'show_user'])->name('news.show');

Route::get('/gallery', [WisataController::class, 'index'])->name('galleries');
Route::delete('/gallery/{id}', [WisataController::class, 'destroy'])
    ->name('gallery.destroy')
    ->middleware('auth');
Route::get('/kegiatan', [EventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{event}', [EventController::class, 'show_user'])->name('events.show');
Route::get('/maps', [AttractionController::class, 'maps'])->name('maps');
// =========================== //
// AUTH ROUTES (Admin & User)  //
// =========================== //
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login_proses'])->name('login.proses');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');
});

// ===========================
// USER ROUTES (Login Required)
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/galeri', [WisataController::class, 'store'])->name('gallery.store');
    Route::get('/dashboard-user', function () {
        return view('frontend.index');
    })->name('user.dashboard');
});

// ===========================
// ADMIN ROUTES (Login Required)
// ===========================
Route::middleware(['auth', 'role:dinas_pariwisata'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        // Grup untuk Users
        Route::prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
                Route::get('/created-success/{id}', [UserController::class, 'createdSuccess'])->name('created.success');
            });
        // Grup untuk Kecamatan
        Route::prefix('kecamatan')
            ->name('subdistricts.')
            ->group(function () {
                Route::get('/', [SubdistrictController::class, 'index'])->name('index');
                Route::post('/', [SubdistrictController::class, 'store'])->name('store');
                Route::put('/{subdistrict}', [SubdistrictController::class, 'update'])->name('update');
                Route::delete('/{subdistrict}', [SubdistrictController::class, 'destroy'])->name('destroy');
            });

        // Grup untuk Galeri
        Route::prefix('galeri')
            ->name('galleries.')
            ->group(function () {
                Route::get('/', [WisataController::class, 'index_dashboard'])->name('index');
                Route::post('/{id}/approve', [WisataController::class, 'approve'])->name('approve');
                Route::post('/{id}/reject', [WisataController::class, 'reject'])->name('reject');
            });

        Route::prefix('berita')
            ->name('news.')
            ->group(function () {
                Route::post('/{id}/approve', [BeritaController::class, 'approve'])->name('approve');
                Route::post('/{id}/reject', [BeritaController::class, 'reject'])->name('reject');
            });

        Route::prefix('objek-wisata')
            ->name('attractions.')
            ->group(function () {
                Route::get('/', [AttractionController::class, 'index_dashboard'])->name('index'); 
                Route::get('/create', [AttractionController::class, 'create'])->name('create');  
                Route::post('/', [AttractionController::class, 'store'])->name('store');  
                Route::get('/{id}', [AttractionController::class, 'show'])->name('show');  
                Route::get('/{id}/edit', [AttractionController::class, 'edit'])->name('edit');  
                Route::put('/{id}', [AttractionController::class, 'update'])->name('update'); 
                Route::delete('/{id}', [AttractionController::class, 'destroy'])->name('destroy'); 
            });

            
            Route::prefix('wisatawan')
            ->name('tourists.')
            ->group(function () {
                Route::get('/', [TouristController::class, 'index'])->name('index');
                Route::post('/', [TouristController::class, 'store'])->name('store');
                Route::put('/{id}', [TouristController::class, 'update'])->name('update');
                Route::delete('/{id}', [TouristController::class, 'destroy'])->name('destroy');
            });
    });

Route::middleware(['auth', 'role:pengelola,dinas_pariwisata'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::prefix('berita')
            ->name('news.')
            ->group(function () {
                Route::get('/', [BeritaController::class, 'index_dashboard'])->name('index');
                Route::get('/create', [BeritaController::class, 'create'])->name('create');
                Route::post('', [BeritaController::class, 'store'])->name('store');
                Route::get('/{id}', [BeritaController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [BeritaController::class, 'update'])->name('update');
                Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('destroy');
            });
            
            Route::prefix('kegiatan')
            ->name('events.')
            ->group(function () {
                Route::get('/', [EventController::class, 'index_dashboard'])->name('index');
                Route::get('/create', [EventController::class, 'create'])->name('create');
                Route::post('/', [EventController::class, 'store'])->name('store');
                Route::get('/{event}', [EventController::class, 'show'])->name('show');
                Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
                Route::put('/{event}', [EventController::class, 'update'])->name('update');
                Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
            });
        });
            
            

Route::middleware(['auth', 'role:pengelola'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::prefix('pariwisata')
            ->name('attractions.')
            ->group(function () {
                Route::get('/', [AttractionController::class, 'show_pengelola'])->name('show.pengelola');
                Route::get('/edit', [AttractionController::class, 'edit_pengelola'])->name('edit.pengelola');
                Route::put('/update', [AttractionController::class, 'update_pengelola'])->name('update.pengelola');
            });
    });

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Manajemen User
    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');

    // Objek Wisata
    Route::get('/objek-wisata', [WisataController::class, 'index'])->name('objek-wisata.index');
    Route::get('/objek-wisata/create', [WisataController::class, 'create'])->name('objek-wisata.create');
    Route::post('/objek-wisata/store', [WisataController::class, 'store'])->name('objek-wisata.store');
    Route::get('/objek-wisata/edit/{id}', [WisataController::class, 'edit'])->name('objek-wisata.edit');
    Route::put('/objek-wisata/update/{id}', [WisataController::class, 'update'])->name('objek-wisata.update');
    Route::delete('/objek-wisata/delete/{id}', [WisataController::class, 'delete'])->name('objek-wisata.delete');

    // Berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita/store', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/delete/{id}', [BeritaController::class, 'delete'])->name('berita.delete');

    // DataTable
    Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');
});
