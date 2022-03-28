<div class="grid grid-cols-2 gap-4">
    <div>
        <x-dynamic-component :component="'app-ui::' . $type" :label="$label ?? Str::studly($field)" :wire:model.lazy="$field" />
    </div>

    @include('product-comparison::admin.translate', ['field' => $field])
</div>
