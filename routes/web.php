<?php

use App\Livewire\HomePage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage; // <-- Import
use App\Livewire\OrderSuccessPage; // <-- Import
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomePage::class)->name('home');
// Route untuk halaman keranjang belanja
Route::get('/keranjang', CartPage::class)->name('cart.index');
Route::get('/checkout', CheckoutPage::class)->name('checkout.index');
Route::get('/pesanan-berhasil/{pesanan}', OrderSuccessPage::class)->name('order.success');
