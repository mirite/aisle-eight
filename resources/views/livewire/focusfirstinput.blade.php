<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $form;
    public function mount(string $form = 'entry'): void
    {
        $this->form = $form;
    }
};
//
?>
<div class="hidden">
    @script
        <script type="module">
            Livewire.on('formSubmitted', () => {
                const form = document.querySelector('form[data-form="{{ $form }}"]');
                const firstInput = form.querySelector('input, select, textarea');
                if (firstInput) {
                    firstInput.focus();
                }
            });
        </script>
    @endscript
</div>
