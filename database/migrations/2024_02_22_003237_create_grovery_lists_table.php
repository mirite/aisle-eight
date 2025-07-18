<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists( 'grocery_lists' );
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create( 'grocery_lists', function ( Blueprint $table ) {
			$table->id();
			$table->timestamps();
			$table->foreignId( 'user_id' )->constrained( 'users' )->cascadeOnDelete();
			$table->string( 'title' )->nullable();
		} );
	}
};
