<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        if ( !Schema::hasTable('aisle_items') ) {
            Schema::create( 'aisle_items', function ( Blueprint $table ) {
                $table->id();
                $table->foreignId( 'aisle_id' )->constrained( 'aisles' )->cascadeOnDelete();
                $table->foreignId( 'item_id' )->constrained( 'items' )->cascadeOnDelete();
                $table->foreignId( 'user_id' )->constrained( 'users' )->cascadeOnDelete();
                $table->decimal( 'price', 8, 2 )->nullable();
                $table->string( 'description' )->default( '' );
                $table->integer( 'position' )->default( 0 );
                $table->timestamps();
            } );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aisle_items');
    }
};
