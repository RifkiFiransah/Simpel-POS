<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generateInvoice(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        
        $pdf = Pdf::loadView('invoice.template', compact('transaction'));
        
        return $pdf->stream("invoice-{$transaction->invoice_number}.pdf");
    }
    
    public function printInvoice(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        
        return view('invoice.print', compact('transaction'));
    }
}
