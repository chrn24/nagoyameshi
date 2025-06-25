<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Middleware\EnsurePremium;
use App\Http\Controllers\Admin\ShopController as AdminShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/mypage', [UserController::class, 'mypage'])->name('users.mypage');
    Route::get('/users/show', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
});

Route::middleware(['auth', EnsurePremium::class])->group(function () {
    Route::get('/reservations/create/{shop}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::get('/reviews/create/{shop}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});


Route::get('/', [ShopController::class, 'top'])->name('top'); // トップページ（検索フォーム）
Route::get('/shops', [ShopController::class, 'search'])->name('shops.search');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
 // 有料会員へアップグレードの案内ページ（未会員・無料・有料すべてアクセスOK）
Route::get('/users/upgrade', [UpgradeController::class, 'index'])->name('users.upgrade');

// 管理者ページ
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/users', 'admin.users.index')->name('users.index');
    Route::view('/categories', 'admin.categories.index')->name('categories.index');
    Route::resource('shops', AdminShopController::class);
    Route::post('/shops/confirm', [AdminShopController::class, 'confirm'])->name('shops.confirm');
});

require __DIR__.'/auth.php';
