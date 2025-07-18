<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists( 'stores' );
	}

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create( 'stores', function ( Blueprint $table ) {
			$table->id();
			$table->timestamps();
			$table->string( 'name' );
			$table->foreignId( 'user_id' )->constrained( 'users' )->cascadeOnDelete();
		} );
	}
};
