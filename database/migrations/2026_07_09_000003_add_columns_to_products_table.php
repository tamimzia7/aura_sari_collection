<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_code')->nullable()->after('id');
            $table->foreignId('collection_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_trending')->default(false)->after('is_best_selling');
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock')->after('stock_quantity');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_code', 'collection_id', 'is_trending', 'stock_status']);
        });
    }
};
