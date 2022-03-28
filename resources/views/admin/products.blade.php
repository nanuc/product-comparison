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
                                {{ $feature->getTranslation('name', $mainLanguage) }}<br>

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
                                {{ $feature->getTranslation('name', $mainLanguage) }}<br>

                                <x-app-ui::textarea :wire:model.lazy="'pivotValues.' . $feature->id . '.value.' . app()->getLocale()" />
                            </div>
                            <div>
                                @if($mainLanguage != app()->getLocale())
                                    <div class="text-gray-600 text-sm">
                                        Original: {{ Arr::get($pivotValues, $feature->id. '.value.' . $mainLanguage) }}
                                    </div>

                                    <x-app-ui::button size="sm" class="mt-2" wire:click="translatePivotWithDeepL('value', {{ $feature->id }})">
                                        Translate with DeepL
                                    </x-app-ui::button>
                                @endif
                            </div>
                        @endif

                        <div>
                            <x-app-ui::textarea label="Comments" :wire:model.lazy="'pivotValues.' . $feature->id . '.comments.' . app()->getLocale()" />
                        </div>
                        <div>
                            @if($mainLanguage != app()->getLocale())
                                <div class="text-gray-600 text-sm">
                                    Original: {{ Arr::get($pivotValues, $feature->id. '.comments.' . $mainLanguage) }}
                                </div>

                                <x-app-ui::button size="sm" class="mt-2" wire:click="translatePivotWithDeepL('comments', {{ $feature->id }})">
                                    Translate with DeepL
                                </x-app-ui::button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </x-helpers::tab>
        <x-helpers::tab name="Price models">

        </x-helpers::tab>
    </x-helpers::tabs>

@endsection
