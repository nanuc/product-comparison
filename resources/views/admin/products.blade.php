<div>
    <div class="flex">
        <div class="flex-none">
            @foreach($productComparison->products->sortBy('name') as $aProduct)
                <div class="cursor-pointer" wire:click="setProduct({{ $aProduct->id }})">
                    <x-app-ui::link>
                        {{ $aProduct->name }}
                    </x-app-ui::link>
                </div>
            @endforeach
        </div>
        <div class="ml-4 flex-1">
            @if(isset($product))
            {{ $product }}
            @endif
        </div>
    </div>
</div>

