@include('components.form-input', [
    'label' => 'Name',
    'id' => 'name',
    'model' => 'name',
    'placeholder' => __('What do you call it?'),
    'error' => $errors->get('name'),
])
