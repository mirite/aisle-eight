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
        Schema::create('list_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('grocery_list_id')->constrained('grocery_lists');
            $table->foreignId('aisle_item_id')->constrained('aisle_items');
            $table->integer('quantity')->nullable();
            $table->boolean('in_cart')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_items');
    }
};
