<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IncomeController;

Route::get('/', [UserController::class,'index']);
Route::post('/findatable', [UserController::class,'findATable'])->name('book.table');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UserController::class,'home'])->name('dashboard');
    Route::post('/addtocart', [UserController::class,'addToCart'])->name('addtocart');
    Route::get('/foodcart', [UserController::class,'foodCart'])->name('food.cart');
    Route::get('/foodcart/{id}', [UserController::class,'removeCart'])->name('delete.cart');
    Route::post('/confrim_order', [UserController::class,'confrimOrderCart'])->name('cart.confirm');
    Route::get('/order_status', [UserController::class,'orderStatus'])->name('order_status');
});

Route::get('/adminfile', [UserController::class,'gofile'])->middleware('auth','admin');

Route::get('/addfood' , [AdminController::class,'addFood'])->middleware('auth','admin')->name('admin.addfood');

Route::post('/addfood' , [AdminController::class,'postAddFood'])->middleware('auth','admin')->name('admin.postaddfood');

Route::get('/showfood' , [AdminController::class,'showFood'])->middleware('auth','admin')->name('admin.showfood');

Route::get('/deletefood/{id}' , [AdminController::class,'deleteFood'])->middleware('auth','admin')->name('admin.deletefood');

Route::get('/updatefood/{id}' , [AdminController::class,'updateFood'])->middleware('auth','admin')->name('admin.updatefood');

Route::post('/updatefood/{id}' , [AdminController::class,'postUpdateFood'])->middleware('auth','admin')->name('admin.postupdatefood');


Route::get('/vieworder' , [AdminController::class,'viewOrders'])->middleware('auth','admin')->name('admin.vieworders');


Route::get('/delivered/{id}' , [AdminController::class,'foodStatusDelivered'])->middleware('auth','admin')->name('admin.delivered');

Route::get('/cancel/{id}' , [AdminController::class,'foodStatusCancel'])->middleware('auth','admin')->name('admin.cancel');

Route::get('/view_booked_table' , [AdminController::class,'viewBookedTable'])->middleware('auth','admin')->name('admin.viewbookedtable');



Route::get('/admin/income', [IncomeController::class, 'index'])->name('admin.income');
Route::post('/admin/income/add', [IncomeController::class, 'store'])->name('admin.income.add');
Route::get('/admin/income/total', [IncomeController::class, 'getDailyTotal'])->name('admin.income.total');














