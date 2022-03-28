<div>
    @if($mainLanguage != app()->getLocale())
        <div class="text-gray-600 text-sm">
            Original: {{ $model->getTranslation($field, $mainLanguage) }}
        </div>

        <x-app-ui::button size="sm" class="mt-2" wire:click="translateWithDeepL('{{ $field }}')">
            Translate with DeepL
        </x-app-ui::button>
    @endif
</div>
