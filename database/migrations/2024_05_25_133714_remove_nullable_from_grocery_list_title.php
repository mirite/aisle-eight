<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::disableForeignKeyConstraints();

		Schema::table( 'grocery_lists', function ( Blueprint $table ) {
			$table->string( 'title' )->nullable()->change();
		} );

		Schema::enableForeignKeyConstraints();
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::disableForeignKeyConstraints();

		Schema::table( 'grocery_lists', function ( Blueprint $table ) {
			$table->string( 'title' )->nullable( false )->change();
		} );

		Schema::enableForeignKeyConstraints();
	}
};
