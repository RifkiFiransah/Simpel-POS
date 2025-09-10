<?php

namespace App\Http\Controllers;

use App\Models\AboutShop;
use App\Models\Purchase;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generateInvoice(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        $about = AboutShop::first();

        $pdf = Pdf::loadView('invoice.template', compact('transaction', 'about'));

        return $pdf->stream("invoice-{$transaction->invoice_number}.pdf");
    }

    public function generatePurchaseInvoice(Purchase $purchase)
    {
        // Assuming you have a Purchase model similar to Transaction
        $purchase->load(['items.product', 'supplier', 'user']);
        $about = AboutShop::first();

        $pdf = Pdf::loadView('invoice.purchase-template', compact('purchase', 'about'));

        return $pdf->stream("invoice-purchase-{$purchase->invoice_number}.pdf");
    }
    
    public function printInvoice(Transaction $transaction)
    {
        $about = AboutShop::first();
        $transaction->load(['items.product', 'customer', 'user']);

        return view('invoice.print', compact('transaction', 'about'));
    }

    public function printPurchaseInvoice(Purchase $purchase)
    {
        // Assuming you have a Purchase model similar to Transaction
        $purchase->load(['items.product', 'supplier', 'user']);
        $about = AboutShop::first();

        return view('invoice.print-purchase', compact('purchase', 'about'));
    }
}
