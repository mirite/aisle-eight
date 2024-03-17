@include('livewire.forminput', [
    'label' => __('Description'),
    'id' => 'description',
    'model' => 'description',
    'placeholder' => __('Like the banana aisle (Where the bananas are)'),
    'error' => $errors->get('description'),
])
@include('livewire.forminput', [
    'label' => __('Position'),
    'id' => 'position',
    'model' => 'position',
    'type' => 'number',
    'placeholder' => __('Where it lives in the store'),
    'error' => $errors->get('position'),
])
@include('livewire.formselect', [
    'label' => __('Store'),
    'id' => 'store_id',
    'model' => 'store_id',
    'children' => $stores,
    'placeholder' => __('Select a store'),
    'childLabelField' => 'name',
    'error' => $errors->get('store_id'),
])
