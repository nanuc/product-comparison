@extends('product-comparison::admin.base-view')

@section('content')
    <x-helpers::tabs>
        <x-helpers::tab name="Basic settings">
            @include('product-comparison::admin.partials.name-comments-description')

            <div>
                <x-app-ui::input label="URL" wire:model.lazy="url" />
            </div>

            @include('product-comparison::admin.partials.delete')
        </x-helpers::tab>
        <x-helpers::tab name="Features">
            @foreach($productComparison->features->groupBy(fn($feature) => $feature->type->value) as $type => $featureGroup)
                @foreach($featureGroup as $feature)
                    <div class="grid grid-cols-4 gap-4">
                        @if($type == 'boolean')
                            <div class="mb-2 col-span-2">
                                <div class="font-bold mb-2">
                                    {{ $feature->getTranslation('name', $mainLanguage) }}
                                </div>

                                @if($mainLanguage != app()->getLocale())
                                    <div class="text-gray-600 text-xs">
                                        Original:
                                        @if(Arr::get($productFeatures, $feature->id . '.value.' . $mainLanguage) === true)
                                            true
                                        @elseif(Arr::get($productFeatures, $feature->id . '.value.' . $mainLanguage) === false)
                                            false
                                        @else
                                            unknown
                                        @endif
                                    </div>
                                @endif

                                <x-app-ui::button wire:click="setFeature({{ $feature->id }}, true)" :color="Arr::get($productFeatures, $feature->id . '.value.' . app()->getLocale()) === true ? 'primary' : 'secondary'">
                                    true
                                </x-app-ui::button>
                                <x-app-ui::button wire:click="setFeature({{ $feature->id }}, false)" :color="Arr::get($productFeatures, $feature->id . '.value.' . app()->getLocale()) === false ? 'primary' : 'secondary'">
                                    false
                                </x-app-ui::button>
                                <x-app-ui::button wire:click="setFeature({{ $feature->id }}, null)" :color="Arr::get($productFeatures, $feature->id . '.value.' . app()->getLocale()) !== true && Arr::get($productFeatures, $feature->id . '.value.' . app()->getLocale()) !== false ? 'primary' : 'secondary'">
                                    unknown
                                </x-app-ui::button>
                            </div>
                        @else
                            <div>
                                <div class="font-bold mb-2">
                                    {{ $feature->getTranslation('name', $mainLanguage) }}
                                </div>

                                @if($type == 'text')
                                    <x-app-ui::textarea :wire:model.lazy="'featureValues.' . $feature->id . '.value.' . app()->getLocale()" />
                                @elseif($type == 'enum')
                                    <x-app-ui::input :wire:model.lazy="'featureValues.' . $feature->id . '.value.' . app()->getLocale()" />
                                @elseif($type == 'number')
                                    <x-app-ui::input type="number" :wire:model.lazy="'featureValues.' . $feature->id . '.value.' . app()->getLocale()" />
                                @endif
                            </div>
                            <div>
                                @if($mainLanguage != app()->getLocale())
                                    <div class="text-gray-600 text-sm">
                                        Original: {{ Arr::get($featureValues, $feature->id. '.value.' . $mainLanguage) }}
                                    </div>

                                    <x-app-ui::button size="sm" class="mt-2" wire:click="translatePivotWithDeepL('featureValues', 'value', {{ $feature->id }})">
                                        Translate with DeepL
                                    </x-app-ui::button>
                                @endif
                            </div>
                        @endif

                        <div>
                            <x-app-ui::textarea label="Comments" :wire:model.lazy="'featureValues.' . $feature->id . '.comments.' . app()->getLocale()" />
                        </div>
                        <div>
                            @if($mainLanguage != app()->getLocale())
                                <div class="text-gray-600 text-sm">
                                    Original: {{ Arr::get($featureValues, $feature->id. '.comments.' . $mainLanguage) }}
                                </div>

                                <x-app-ui::button size="sm" class="mt-2" wire:click="translatePivotWithDeepL('featureValues', 'comments', {{ $feature->id }})">
                                    Translate with DeepL
                                </x-app-ui::button>
                            @endif
                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr class="mt-2 mb-2" />
                    @endif
                @endforeach
                @if(!$loop->last)
                    <hr class="mt-2 mb-2" />
                @endif
            @endforeach
        </x-helpers::tab>
        <x-helpers::tab name="Price models">
            @foreach($productComparison->priceModels as $priceModel)
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-2">
                        <div class="font-bold mb-2">
                            {{ $priceModel->getTranslation('name', $mainLanguage) }}
                        </div>

                        <div class="flex space-x-2">
                            <x-app-ui::input :wire:model.lazy="'priceValues.' . $priceModel->id . '.price'" />
                            <x-app-ui::select :wire:model.lazy="'priceValues.' . $priceModel->id . '.currency'">
                                <option>EUR</option>
                                <option>USD</option>
                            </x-app-ui::select>
                        </div>
                    </div>

                    <div>
                        <x-app-ui::textarea label="Comments" :wire:model.lazy="'priceValues.' . $priceModel->id . '.comments.' . app()->getLocale()" />
                    </div>
                    <div>
                        @if($mainLanguage != app()->getLocale())
                            <div class="text-gray-600 text-sm">
                                Original: {{ Arr::get($priceValues, $priceModel->id. '.comments.' . $mainLanguage) }}
                            </div>

                            <x-app-ui::button size="sm" class="mt-2" wire:click="translatePivotWithDeepL('priceValues', 'comments', {{ $priceModel->id }})">
                                Translate with DeepL
                            </x-app-ui::button>
                        @endif
                    </div>
                </div>

                @if(!$loop->last)
                    <hr class="mt-2 mb-2" />
                @endif
            @endforeach
        </x-helpers::tab>
        <x-helpers::tab name="Downloads">
            @foreach($productComparison->languages as $language)
                <x-app-ui::button wire:click="downloadExcel('{{ $language }}')">
                    Download Excel ({{ $language }})
                </x-app-ui::button>
            @endforeach
        </x-helpers::tab>
    </x-helpers::tabs>
@endsection
