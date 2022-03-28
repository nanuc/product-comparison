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
        </div>
        @if($model)
            <div class="ml-4 flex-1">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-app-ui::input label="Name" wire:model.lazy="name" />
                    </div>
                    @include('product-comparison::admin.translate', ['field' => 'name'])
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-app-ui::textarea label="Comments" wire:model.lazy="comments" />
                    </div>
                    @include('product-comparison::admin.translate', ['field' => 'comments'])
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-app-ui::textarea label="Description" wire:model.lazy="description" />
                    </div>
                    @include('product-comparison::admin.translate', ['field' => 'description'])
                </div>

                @yield('content')

            </div>
        @endif
    </div>
</div>

