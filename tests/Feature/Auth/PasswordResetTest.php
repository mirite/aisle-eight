<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PasswordResetTest extends TestCase {
	use RefreshDatabase;

	public function test_password_can_be_reset_with_valid_token(): void {
		Notification::fake();

		$user = User::factory()->create();

		Volt::test( 'pages.auth.forgot-password' )
			->set( 'email', $user->email )
			->call( 'sendPasswordResetLink' );

		Notification::assertSentTo( $user, ResetPassword::class, function ( $notification ) use ( $user ) {
			$component = Volt::test( 'pages.auth.reset-password', array( 'token' => $notification->token ) )
				->set( 'email', $user->email )
				->set( 'password', 'password' )
				->set( 'password_confirmation', 'password' );

			$component->call( 'resetPassword' );

			$component
				->assertRedirect( '/login' )
				->assertHasNoErrors();

			return true;
		} );
	}

	public function test_reset_password_link_can_be_requested(): void {
		Notification::fake();

		$user = User::factory()->create();

		Volt::test( 'pages.auth.forgot-password' )
			->set( 'email', $user->email )
			->call( 'sendPasswordResetLink' );

		Notification::assertSentTo( $user, ResetPassword::class );
	}

	public function test_reset_password_link_screen_can_be_rendered(): void {
		$response = $this->get( '/forgot-password' );

		$response
			->assertSeeVolt( 'pages.auth.forgot-password' )
			->assertStatus( 200 );
	}

	public function test_reset_password_screen_can_be_rendered(): void {
		Notification::fake();

		$user = User::factory()->create();

		Volt::test( 'pages.auth.forgot-password' )
			->set( 'email', $user->email )
			->call( 'sendPasswordResetLink' );

		Notification::assertSentTo( $user, ResetPassword::class, function ( $notification ) {
			$response = $this->get( '/reset-password/'.$notification->token );

			$response
				->assertSeeVolt( 'pages.auth.reset-password' )
				->assertStatus( 200 );

			return true;
		} );
	}
}
