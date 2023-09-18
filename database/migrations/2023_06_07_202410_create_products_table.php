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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('model', 20);
            $table->decimal('purchasePrice', 10, 2);
            $table->decimal('salePrice', 10, 2);
            $table->text('description')->nullable();
            $table->string('productType', 20)->nullable();
            $table->foreignId('employeeId')->constrained('users');
            $table->decimal('promotionalPrice', 10, 2)->nullable();
            $table->date('promotionalOutdated')->nullable();
            $table->integer('stock');
            $table->integer('threshold');
            $table->string('images', 255)->nullable();
            $table->string('address', 100);
            $table->boolean('canReserve')->default(false);
            $table->boolean('isTendency')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
