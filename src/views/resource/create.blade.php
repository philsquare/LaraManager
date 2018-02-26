@extends('laramanager::layouts.sub.default')

@section('title')
    {{ $resource->title or 'Create' }}
@endsection

@section('head')

@endsection

@section('page-content')

    <image-browser-modal v-on:image-selected="setSelectedImage"></image-browser-modal>

    <form action="{{ route('admin.' . $resource->slug . '.store') }}" enctype="multipart/form-data" method="POST" class="uk-form uk-form-stacked">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @foreach($resource->fields as $field)

            @include('laramanager::fields.' . $field->type . '.field', compact('field'))

        @endforeach

        <textarea name="stuff" id="html-editor" cols="30" rows="10"></textarea>

        <div class="uk-form-row">
            <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-6">Save</button>
        </div>

    </form>

@endsection

@push('scripts-last')

    @include('laramanager::resource.assets')

@endpush