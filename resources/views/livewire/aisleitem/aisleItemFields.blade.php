@include('livewire.form-select', [
    'label' => __('Item'),
    'id' => 'item_id',
    'model' => 'item_id',
    'children' => $items,
    'placeholder' => __('Select an item'),
    'childLabelField' => 'name',
    'error' => $errors->get('item_id'),
])
@include('livewire.form-select', [
    'label' => __('Aisle'),
    'id' => 'aisle_id',
    'model' => 'aisle_id',
    'children' => $aisles,
    'placeholder' => __('Select an aisle'),
    'childLabelField' => fn($aisle) => $aisle->store->name . '->' . $aisle->description,
    'error' => $errors->get('aisle_id'),
])
@include('livewire.form-input', [
    'label' => __('Price'),
    'id' => 'price',
    'model' => 'price',
    'placeholder' => __('Optional'),
    'error' => $errors->get('price'),
])
@include('livewire.form-input', [
    'label' => __('Units'),
    'id' => 'description',
    'model' => 'description',
    'placeholder' => __('Like "Per Pound" or "Per Each""'),
    'error' => $errors->get('description'),
])
@include('livewire.form-input', [
    'label' => __('Position'),
    'id' => 'position',
    'model' => 'position',
    'type' => 'number',
    'placeholder' => __('Where it lives in the aisle'),
    'error' => $errors->get('position'),
])
