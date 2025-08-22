<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::with('category')->get();
        
        return view('transaction.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'method' => 'required|in:cash,transfer,qris,debit',
            'payment' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
        ], [
            'items.required' => 'Minimal harus ada 1 item dalam transaksi',
            'items.*.product_id.required' => 'Produk harus dipilih',
            'items.*.quantity.min' => 'Quantity minimal 1',
            'payment.min' => 'Jumlah pembayaran tidak boleh negatif',
        ]);

        try {
            DB::beginTransaction();

            // Create transaction
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id() ?? 1, // Default to user ID 1 if not authenticated
                'total' => $request->total,
                'method' => $request->method,
                'payment' => $request->payment,
                'change' => $request->change,
                'date' => now(),
            ]);

            // Create transaction items
            foreach ($request->items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('filament.admin.resources.transactions.view', $transaction)
                ->with('success', 'Transaksi berhasil dibuat! Invoice: ' . $transaction->invoice_number);

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat transaksi: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items.product.category']);
        
        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
