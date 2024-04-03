@php($hide = $hide ?? [])
<div class="flex gap-2 flex-col">
    @if (!in_array('name', $hide))
        <div class="font-bold">{{ $aisleItem->item->name }}</div>
    @endif
    <x-stack-mobile class="justify-between">
        @if (!in_array('store', $hide))
            <x-stack-mobile><span
                    class="font-semibold">Store:</span>{{ $aisleItem->aisle->store->name }}</x-stack-mobile>
        @endif
        @if (!in_array('aisle', $hide))
            <x-stack-mobile><span
                    class="font-semibold">Aisle:</span>{{ $aisleItem->aisle->description }}</x-stack-mobile>
        @endif
    </x-stack-mobile>
    <x-stack-mobile class="justify-between">
        <x-stack-mobile><span class="font-semibold">Price:</span>{{ $aisleItem->price }}</x-stack-mobile>
        <x-stack-mobile><span class="font-semibold">Units:</span>{{ $aisleItem->description }}</x-stack-mobile>
    </x-stack-mobile>
    <x-stack-mobile><span class="font-semibold">Last Updated:</span{{ $aisleItem->updated_at }}></x-stack-mobile>
</div>
