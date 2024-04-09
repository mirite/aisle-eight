@include('components.form-input', [
    'label' => 'Name',
    'id' => 'name',
    'model' => 'name',
    'placeholder' => __('Sort of like a story'),
    'error' => $errors->get('name'),
])
