<?php

use function Livewire\Volt\{state};

//

?>

<div>
    @if (!$loop->last)
        <button wire:click="move({{ $args[0] }}, {{ $args[1] }}, 'down' )">down</button>
    @endif
    @if (!$loop->first)
        <button wire:click="move({{ $args[0] }}, {{ $args[1] }}, 'up' )">up</button>
    @endif
</div>
