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

// Invoice Purchase routes
Route::get('/invoice/purchase/{purchase}/pdf', [InvoiceController::class, 'generatePurchaseInvoice'])->name('invoice.purchase.pdf');
Route::get('/invoice/purchase/{purchase}/print', [InvoiceController::class, 'printPurchaseInvoice'])->name('invoice.purchase.print');

// Export routes
Route::prefix('export')->name('export.')->group(function () {
    // Transaction exports
    Route::get('/transactions/excel', [TransactionExportController::class, 'exportExcel'])->name('transactions.excel');
    Route::get('/transactions/pdf', [TransactionExportController::class, 'exportPDF'])->name('transactions.pdf');

    // Purchase exports
    Route::get('/purchases/excel', [TransactionExportController::class, 'exportPurchasesExcel'])->name('purchases.excel');
    Route::get('/purchases/pdf', [TransactionExportController::class, 'exportPurchasesPDF'])->name('purchases.pdf');

    // Master data exports
    Route::get('/products/excel', [TransactionExportController::class, 'exportProductsExcel'])->name('products.excel');
    Route::get('/customers/excel', [TransactionExportController::class, 'exportCustomersExcel'])->name('customers.excel');
    Route::get('/suppliers/excel', [TransactionExportController::class, 'exportSuppliersExcel'])->name('suppliers.excel');
    Route::get('/categories/excel', [TransactionExportController::class, 'exportCategoriesExcel'])->name('categories.excel');
    Route::get('/users/excel', [TransactionExportController::class, 'exportUsersExcel'])->name('users.excel');
});
