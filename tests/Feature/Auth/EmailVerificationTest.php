<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Event, URL};
use Tests\TestCase;

class EmailVerificationTest extends TestCase {
	use RefreshDatabase;

	public function test_email_can_be_verified(): void {
		$user = User::factory()->create( array(
			'email_verified_at' => null,
		) );

		Event::fake();

		$verificationUrl = URL::temporarySignedRoute(
			'verification.verify',
			now()->addMinutes( 60 ),
			array( 'id' => $user->id, 'hash' => sha1( $user->email ) )
		);

		$response = $this->actingAs( $user )->get( $verificationUrl );

		Event::assertDispatched( Verified::class );
		$this->assertTrue( $user->fresh()->hasVerifiedEmail() );
		$response->assertRedirect( RouteServiceProvider::HOME.'?verified=1' );
	}

	public function test_email_is_not_verified_with_invalid_hash(): void {
		$user = User::factory()->create( array(
			'email_verified_at' => null,
		) );

		$verificationUrl = URL::temporarySignedRoute(
			'verification.verify',
			now()->addMinutes( 60 ),
			array( 'id' => $user->id, 'hash' => sha1( 'wrong-email' ) )
		);

		$this->actingAs( $user )->get( $verificationUrl );

		$this->assertFalse( $user->fresh()->hasVerifiedEmail() );
	}

	public function test_email_verification_screen_can_be_rendered(): void {
		$user = User::factory()->create( array(
			'email_verified_at' => null,
		) );

		$response = $this->actingAs( $user )->get( '/verify-email' );

		$response
			->assertSeeVolt( 'pages.auth.verify-email' )
			->assertStatus( 200 );
	}
}
