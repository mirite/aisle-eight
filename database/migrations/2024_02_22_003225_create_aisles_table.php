<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists( 'aisles' );
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create( 'aisles', function ( Blueprint $table ) {
			$table->id();
			$table->timestamps();
			$table->foreignId( 'store_id' )->constrained( 'stores' )->cascadeOnDelete();
			$table->string( 'description' );
			$table->integer( 'position' )->default( 0 );
			$table->foreignId( 'user_id' )->constrained( 'users' )->cascadeOnDelete();
		} );
	}
};
