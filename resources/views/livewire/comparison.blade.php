<div>
    <div x-data="{ active: 0 }" class="space-y-4 mb-4" x-cloak>
        <div x-data="{
        id: 1,
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        },
    }" role="region" class="border border-black rounded-md shadow">
            <h2>
                <button
                    x-on:click="expanded = !expanded"
                    :aria-expanded="expanded"
                    class="flex items-center justify-between w-full font-bold px-6 py-3"
                >
                    <span>{{ __('Filters') }}</span>
                    <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                    <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                </button>
            </h2>

            <div x-show="expanded" x-collapse>
                <div class="pb-4 px-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                        <div>
                            <x-product-comparison::heading :label="__('Products')" />

                            @foreach($comparison->products as $product)
                                <x-checkbox :label="$product->name" model="selectedProducts" :value="$product->id" />
                            @endforeach
                        </div>

                        @foreach($comparison->features->where('type', \Nanuc\ProductComparison\Enums\FeatureType::ENUM) as $feature)
                            <div>
                                <x-product-comparison::heading :label="$feature->name" />

                                @foreach($feature->getOptions() as $option)
                                    <x-checkbox :label="$option" model="selectedFeatures.{{ $feature->id }}" :value="$option" />
                                @endforeach
                            </div>
                        @endforeach

                        <div>
                            <x-product-comparison::heading :label="__('Features')" />
                            @foreach($comparison->features->where('type', \Nanuc\ProductComparison\Enums\FeatureType::BOOLEAN) as $feature)
                                <x-checkbox :label="$feature->name" model="selectedFeatures.{{ $feature->id }}" :value="$feature->id" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <table class="min-w-full border-separate" style="border-spacing: 0">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
            </th>
            @foreach($products as $product)
                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
                    {{ $product->name }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($comparison->features as $feature)
                <tr>
                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                        {{ $feature->name }}
                    </td>

                    @foreach($products as $product)
                        <td class="whitespace-nowrap border-b py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6 lg:pl-8">
                            {!! $product->renderFeature($feature) !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach

            @foreach($comparison->priceModels as $priceModel)
                <tr>
                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                        {{ $priceModel->name }}
                    </td>

                    @foreach($products as $product)
                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6 lg:pl-8">
                            {!! $product->getPrice($priceModel) !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

