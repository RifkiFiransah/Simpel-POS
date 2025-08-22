<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

// Invoice routes
Route::get('/invoice/{transaction}/pdf', [InvoiceController::class, 'generateInvoice'])->name('invoice.pdf');
Route::get('/invoice/{transaction}/print', [InvoiceController::class, 'printInvoice'])->name('invoice.print');
