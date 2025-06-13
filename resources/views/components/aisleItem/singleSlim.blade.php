<div class="flex gap-2 flex-col md:flex-row"><span>{{ $item->item->name }}</span>
				@if ($showStore ?? true)
								<span>{{ $item->aisle->store->name }}</span>
				@endif
				@if ($showPrice ?? true)
								<span>{{ $item->price }}</span>
				@endif
				<span>{{ $item->description }}</span>
</div>
