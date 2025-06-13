<x-guest-layout>
				<div class="flex flex-col justify-center items-center">
								<h1>Welcome to Aisle Eight</h1>
								@if (Route::has('login'))
												<livewire:welcome.navigation />
								@endif
				</div>
</x-guest-layout>
