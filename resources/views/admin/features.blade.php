@extends('product-comparison::admin.base-view')

@section('content')
    @include('product-comparison::admin.partials.name-comments-description')

    <div class="w-1/2">
        <x-app-ui::select label="Type" wire:model="type">
            <option>boolean</option>
            <option>enum</option>
            <option>text</option>
        </x-app-ui::select>
    </div>

    @include('product-comparison::admin.partials.delete')
@endsection
