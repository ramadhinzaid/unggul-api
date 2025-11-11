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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->string('note');
            $table->string('stock_code');
            $table->integer('qty');
            $table->timestamps();

            // Foreign keys
            $table->foreign('note')
                ->references('id_note')
                ->on('sales')
                ->onDelete('cascade');

            $table->foreign('stock_code')
                ->references('code')
                ->on('stocks')
                ->onDelete('cascade');

            $table->unique(['note', 'stock_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
