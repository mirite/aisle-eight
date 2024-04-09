<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Collection;

trait Movable
{
    /**
     * Move the model up or down.
     * @throws Exception if the model does not have a position property.
     */
    public function move(Collection $collection, string $direction): void
    {
        $orderedItems    = $collection->sortBy('position')->values();
        $targetItemIndex = $orderedItems->search(function ($item) {
            return $item->id === $this->id;
        });

        if ($targetItemIndex === 0 && $direction === 'up') {
            return;
        }
        if ($targetItemIndex === $orderedItems->count() - 1 && $direction === 'down') {
            return;
        }

        $swapIndex = $direction === 'up' ? $targetItemIndex - 1 : $targetItemIndex + 1;
        $swapItem  = $orderedItems->get($swapIndex);

        if ($swapItem) {
            $tempPosition       = $this->position;
            $this->position     = $swapItem->position;
            $swapItem->position = $tempPosition;

            $this->save();
            $swapItem->save();
        }
    }
}
