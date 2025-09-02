<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update transactions table financial columns precision
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total', 15, 2)->default(0)->change();
            $table->decimal('payment', 15, 2)->default(0)->change();
            $table->decimal('change', 15, 2)->default(0)->change();
        });

        // Update purchases table financial columns precision
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('total', 15, 2)->default(0)->change();
            $table->decimal('payment', 15, 2)->default(0)->change();
            $table->decimal('change', 15, 2)->default(0)->change();
        });

        // Update transaction_items table financial columns precision
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->default(0)->change();
            $table->decimal('subtotal', 15, 2)->default(0)->change();
        });

        // Update purchase_items table financial columns precision
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->default(0)->change();
            $table->decimal('subtotal', 15, 2)->default(0)->change();
        });

        // Update products table price column precision
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert transactions table financial columns precision
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->default(0)->change();
            $table->decimal('payment', 10, 2)->default(0)->change();
            $table->decimal('change', 10, 2)->default(0)->change();
        });

        // Revert purchases table financial columns precision
        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->default(0)->change();
            $table->decimal('payment', 10, 2)->default(0)->change();
            $table->decimal('change', 10, 2)->default(0)->change();
        });

        // Revert transaction_items table financial columns precision
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->change();
            $table->decimal('subtotal', 10, 2)->default(0)->change();
        });

        // Revert purchase_items table financial columns precision
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->change();
            $table->decimal('subtotal', 10, 2)->default(0)->change();
        });

        // Revert products table price column precision
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->change();
        });
    }
};
