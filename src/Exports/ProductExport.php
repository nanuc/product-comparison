<?php

namespace Nanuc\ProductComparison\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Nanuc\ProductComparison\Models\Product;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromView, WithStyles, WithColumnWidths
{
    public function __construct(
        private Product $product,
        private $language,
    ) {}

    public function view(): View
    {
        app()->setLocale($this->language);

        return view('product-comparison::admin.export.excel', [
            'product' => $this->product,
            'features' => $this->product->features->mapWithKeys(fn($feature) => [$feature->id => $feature]),
            'priceModels' => $this->product->priceModels->mapWithKeys(fn($priceModels) => [$priceModels->id => $priceModels]),
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 45,
            'B' => 45,
            'C' => 45,
            'D' => 45,
            'E' => 45,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('E1:E' . count($this->product->comparison->features) +  count($this->product->comparison->priceModels) + 1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('fff0b3');

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
