<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout( 'layouts.guest' )] class extends Component {
	public string $email = '';

	/**
				 * Send a password reset link to the provided email address.
				 */
	public function sendPasswordResetLink(): void {
		$this->validate( array(
			'email' => array( 'required', 'string', 'email' ),
		) );

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$status = Password::sendResetLink( $this->only( 'email' ) );

		if ( Password::RESET_LINK_SENT != $status ) {
			$this->addError( 'email', __( $status ) );

			return;
		}

		$this->reset( 'email' );

		session()->flash( 'status', __( $status ) );
	}
}; ?>

<div>
				<div class="mb-4 text-sm text-gray-600">
								{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
				</div>

				<!-- Session Status -->
				<x-auth-session-status class="mb-4" :status="session('status')" />

				<form wire:submit="sendPasswordResetLink">
								<!-- Email Address -->
								<div>
												<x-input-label for="email" :value="__('Email')" />
												<x-input-text wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
																autofocus />
												<x-input-error :messages="$errors->get('email')" class="mt-2" />
								</div>

								<div class="flex items-center justify-end mt-4">
												<x-primary-button>
																{{ __('Email Password Reset Link') }}
												</x-primary-button>
								</div>
				</form>
</div>
