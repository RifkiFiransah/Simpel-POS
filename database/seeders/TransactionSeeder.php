<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user, customer, dan product yang ada
        $users = User::all();
        $customers = Customer::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Make sure you have users and products seeded first!');
            return;
        }

        // Buat beberapa transaksi contoh
        for ($i = 1; $i <= 10; $i++) {
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'user_id' => $users->random()->id,
                'customer_id' => $customers->random()->id ?? null,
                'method' => collect(['cash', 'transfer', 'qris', 'debit'])->random(),
                'total' => 0, // akan dihitung setelah items dibuat
                'payment' => 0,
                'change' => 0,
            ]);

            // Buat 1-3 items per transaksi
            $itemCount = rand(1, 3);
            $total = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $quantity * $price;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Update total, payment, dan change
            $payment = $total + rand(0, 50000); // payment bisa lebih dari total
            $change = $payment - $total;

            $transaction->update([
                'total' => $total,
                'payment' => $payment,
                'change' => $change,
            ]);
        }

        $this->command->info('Transaction seeder completed! Created 10 sample transactions.');
    }
}
