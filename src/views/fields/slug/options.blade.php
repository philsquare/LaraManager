@include('laramanager::partials.elements.form.text', ['field' => ['name' => 'data[target]', 'label' => 'Field Name', 'value' => isset($field) ? unserialize($field->data)['target'] : '']])