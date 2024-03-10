<div class="flex gap-2 flex-col">
    <div class="flex gap-2 justify-between">
        <div class="flex gap-2 "><span class="font-bold">Store:</span>{{ $aisleItem->aisle->store->name }}</div>
        <div class="flex gap-2 "><span class="font-bold">Aisle:</span>{{ $aisleItem->aisle->description }}</div>
    </div>
    <div class="flex gap-2 justify-between">
        <div class="flex gap-2 "><span class="font-bold">Price:</span>{{ $aisleItem->price }}</div>
        <div class="flex gap-2 "><span class="font-bold">Units:</span>{{ $aisleItem->description }}</div>
    </div>
    <div class="flex gap-2 "><span class="font-bold">Last Updated:</span{{$aisleItem->update}}></div>
</div>
