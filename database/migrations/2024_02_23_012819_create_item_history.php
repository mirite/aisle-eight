<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists( 'aisle_item_history' );
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create( 'aisle_item_history', function ( Blueprint $table ) {
			$table->id();
			$table->foreignId( 'aisle_item_id' )->constrained( 'aisle_items' )->cascadeOnDelete();
			$table->decimal( 'price', 8, 2 );
			$table->string( 'description' );
			$table->timestamp( 'changed_at' );
			$table->timestamps();
		} );
	}
};
