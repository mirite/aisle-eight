<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {


	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {


		Schema::table( 'grocery_lists', function ( Blueprint $table ) {
			if( !Schema::hasColumn( 'grocery_lists', 'title' ) ) {
				$table->string( 'title' )->default( '' );;
			}
		} );

	}
};
