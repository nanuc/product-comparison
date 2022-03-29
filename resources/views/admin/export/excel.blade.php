<table>
    <thead>
    <tr>
        <th>Feature / Pricing Model</th>
        <th>Description</th>
        <th>{{ $product->name }}</th>
        <th>Comments</th>
        <th>Your comments</th>
    </tr>
    </thead>
    <tbody>
        @foreach($product->comparison->features as $feature)
            <tr>
                <td>{{ $feature->name }}</td>
                <td>{{ $feature->comments }}</td>
                @if($feature->type == \Nanuc\ProductComparison\Enums\FeatureType::BOOLEAN)
                    @if(Arr::get($features, $feature->id)?->pivot->value === true)
                        <td>yes</td>
                    @elseif(Arr::get($features, $feature->id)?->pivot->value === false)
                        <td>no</td>
                    @else
                        <td>unknown</td>
                    @endif
                @else
                    <td>{{ Arr::get($features, $feature->id)?->pivot->value }}</td>
                @endif
                <td>{{ Arr::get($features, $feature->id)?->pivot->comments }}</td>
                <td></td>
            </tr>
        @endforeach

        @foreach($product->comparison->priceModels as $priceModel)
            <tr>
                <td>{{ $priceModel->name }}</td>
                <td>{{ $priceModel->comments }}</td>
                <td>{{ Arr::get($priceModels, $priceModel->id)?->pivot->price }} {{ Arr::get($priceModels, $priceModel->id)?->pivot->currency }}</td>
                <td>{{ Arr::get($priceModels, $priceModel->id)?->pivot->comments }}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
