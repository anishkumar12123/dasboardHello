<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelUploadController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

// Route::get('/', function () {
//     return view('upload');
// });
Route::post('/upload', [ExcelUploadController::class, 'upload'])->name('excel.upload');
use App\Http\Controllers\DataViewController;

Route::get('/df-invoice', [DataViewController::class, 'dfInvoice'])->name('df-invoice');
Route::get('/approved-coogs', [DataViewController::class, 'approvedCoogs'])->name('approved-coogs');
Route::get('/po-invoice', [DataViewController::class, 'poInvoice'])->name('po-invoice');
Route::get('/remittance', [DataViewController::class, 'remittance'])->name('remittance');
Route::get('/return-data', [DataViewController::class, 'returnData'])->name('return-data');
Route::get('/coogs', [DataViewController::class, 'coogs'])->name('coogs');




// Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
// Route::get('/df-invoice', fn () => view('data.df_invoice'))->name('df-invoice');
// Route::get('/approved-coogs', fn () => view('data.approved_coogs'))->name('approved-coogs');
// Route::get('/po-invoice', fn () => view('data.po_invoice'))->name('po-invoice');
// Route::get('/remittance', fn () => view('data.remittance'))->name('remittance');
// Route::get('/return-data', fn () => view('data.return_data'))->name('return-data');
// Route::get('/coogs', fn () => view('data.coogs'))->name('coogs');
// Route::get('/users', fn () => view('data.users'))->name('users');
