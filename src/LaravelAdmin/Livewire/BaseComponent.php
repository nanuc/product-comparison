<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class BaseComponent extends Component
{
    public \Nanuc\ProductComparison\Models\ProductComparison $productComparison;

    public $language;

    public $name;
    public $description;
    public $comments;
    public $type;

    public $model;
    public $mainLanguage;

    protected $listeners = [
        'updatedLanguage',
    ];

    public function mount()
    {
        $this->mainLanguage = $this->productComparison->getMainLanguage();
    }

    public function render()
    {
        return view('product-comparison::admin.' . Str::kebab($this->getRelation()));
    }

    public function setModel($modelId)
    {
        $this->model = $this->modelClass::find($modelId);

        app()->setLocale($this->language);
        $this->name = $this->model->name;
        $this->comments = $this->model->comments;
        $this->description = $this->model->description;
    }

    public function updatedLanguage($language)
    {
        $this->language = $language;
        if($this->model) {
            $this->setModel($this->model->id);
        }
    }

    public function updated($key, $value)
    {
        app()->setLocale($this->language);
        $this->model->update([
            $key => $value,
        ]);
    }

    public function translateWithDeepL($key)
    {
        app()->setLocale($this->language);
        $this->model->setTranslation($key, $this->language, $this->autoTranslate($this->model->getTranslation($key, $this->mainLanguage)));
        $this->model->save();
        $this->setModel($this->model->id);
    }

    private function autoTranslate($text)
    {
        return Arr::get(Http::get(config('product-comparison.deep-l.endpoint'), [
            'auth_key' => config('product-comparison.deep-l.auth-key'),
            'source_lang' => $this->mainLanguage,
            'target_lang' => $this->language,
            'text' => $text,
        ])->json(), 'translations.0.text');
    }

    public function getAllModels()
    {
        app()->setLocale($this->mainLanguage);
        $models = $this->productComparison->{$this->getRelation()}->sortBy('name');
        app()->setLocale($this->language);

        return $models;
    }

    private function getRelation()
    {
        return lcfirst(Str::of((new \ReflectionClass($this->modelClass))
            ->getShortName())
            ->pluralStudly());
    }
}

