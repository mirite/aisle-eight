<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table( 'aisle_items', function ( Blueprint $table ) {
			$table->dropColumn( 'size' );
			$table->dropColumn( 'units' );
		} );
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table( 'aisle_items', function ( Blueprint $table ) {
			$table->integer( 'size' )->default( 0 );
			$table->enum( 'units', array( 'g', 'kg', 'mL', 'L', 'oz', 'lb','qt', 'pt', 'fl oz' ) )->default( 'g' );
		} );
	}
};
