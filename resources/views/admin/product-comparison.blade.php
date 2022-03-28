<div>
    @if(!$productComparison)
        @foreach(\Nanuc\ProductComparison\Models\ProductComparison::all() as $aProductComparison)
            <x-app-ui::link class="cursor-pointer" wire:click="setProductComparison({{ $aProductComparison->id }})">
                {{ $aProductComparison->name }}
            </x-app-ui::link>
        @endforeach
    @else
        @if(count($allLanguages) > 1)
            <div class="float-right whitespace-nowrap">
                @foreach($allLanguages as $aLanguage)
                    <x-app-ui::link wire:click="$set('language', '{{ $aLanguage }}')" class="cursor-pointer {{ $aLanguage == $language ? 'font-bold' : '' }}">
                        {{ $aLanguage }}
                    </x-app-ui::link>

                    @if(!$loop->last)
                        |
                    @endif
                @endforeach

            </div>
        @endif

        <x-helpers::tabs>
            <x-helpers::tab name="Products">
                <livewire:product-comparison.products :product-comparison="$productComparison" :language="$language"/>
            </x-helpers::tab>
            <x-helpers::tab name="Features">
                <livewire:product-comparison.features :product-comparison="$productComparison" :language="$language"/>
            </x-helpers::tab>
            <x-helpers::tab name="Price Models">
                <livewire:product-comparison.price-models :product-comparison="$productComparison" :language="$language"/>
            </x-helpers::tab>
        </x-helpers::tabs>
    @endif
</div>
