<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout( 'layouts.guest' )] class extends Component {
	public string $password = '';

	/**
				 * Confirm the current user's password.
				 */
	public function confirmPassword(): void {
		$this->validate( array(
			'password' => array( 'required', 'string' ),
		) );

		if (
			!Auth::guard( 'web' )->validate( array(
				'email' => Auth::user()->email,
				'password' => $this->password,
			) )
		) {
			throw ValidationException::withMessages( array(
				'password' => __( 'auth.password' ),
			) );
		}

		session( array( 'auth.password_confirmed_at' => time() ) );

		$this->redirectIntended( default: RouteServiceProvider::HOME, navigate: true );
	}
}; ?>

<div>
				<div class="mb-4 text-sm text-gray-600">
								{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
				</div>

				<form wire:submit="confirmPassword">
								<!-- Password -->
								<div>
												<x-input-label for="password" :value="__('Password')" />

												<x-input-text wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
																required autocomplete="current-password" />

												<x-input-error :messages="$errors->get('password')" class="mt-2" />
								</div>

								<div class="flex justify-end mt-4">
												<x-primary-button>
																{{ __('Confirm') }}
												</x-primary-button>
								</div>
				</form>
</div>
