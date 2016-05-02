@extends('laramanager::partials.wrappers.form')

@section('field')

    <textarea name="{{ $field['name'] }}"
              id="{{ $field['id'] or '' }}"
              class="{{ $errors->has($field['name']) ? 'uk-form-danger' : '' }}" data-uk-htmleditor>{{ old($field['name']) ?: (isset($field['value']) ? $field['value'] : '') }}</textarea>

@overwrite