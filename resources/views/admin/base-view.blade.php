<div>
    <div class="flex">
        <div class="flex-none">
            @foreach($this->getAllModels() as $aModel)
                <div class="cursor-pointer" wire:click="setModel({{ $aModel->id }})">
                    <x-app-ui::link class="{{ $aModel->is($model) ? 'underline font-bold' : '' }}">
                        {{ $aModel->getTranslation('name', $mainLanguage) }}
                    </x-app-ui::link>
                </div>
            @endforeach
            <hr class="mt-2 mb-2">
            <x-app-ui::link class="cursor-pointer" wire:click="addNew">
                Add
            </x-app-ui::link>
        </div>
        @if($model)
            <div class="ml-4 flex-1">
                @yield('content')
            </div>
        @endif
    </div>
</div>

