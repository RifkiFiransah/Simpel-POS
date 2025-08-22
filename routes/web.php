<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionExportController;

Route::get('/', function () {
    return view('welcome');
});

// Invoice routes
Route::get('/invoice/{transaction}/pdf', [InvoiceController::class, 'generateInvoice'])->name('invoice.pdf');
Route::get('/invoice/{transaction}/print', [InvoiceController::class, 'printInvoice'])->name('invoice.print');

// Export routes
Route::get('/export/transactions/excel', [TransactionExportController::class, 'exportExcel'])->name('export.transactions.excel');
Route::get('/export/transactions/pdf', [TransactionExportController::class, 'exportPDF'])->name('export.transactions.pdf');
