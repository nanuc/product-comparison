<div>
    @if(!$productComparison)
        @foreach(\Nanuc\ProductComparison\Models\ProductComparison::all() as $aProductComparison)
            <x-app-ui::link wire:click="setProductComparison({{ $aProductComparison->id }})">
                {{ $aProductComparison->name }}
            </x-app-ui::link>

            @dump($productComparison)
        @endforeach
    @else
        <x-helpers::tabs>
            <x-helpers::tab name="t1">
                asdf
            </x-helpers::tab>
            <x-helpers::tab name="t2">
                dsfsdf
            </x-helpers::tab>
        </x-helpers::tabs>
    @endif
</div>
