<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use Carbon\Carbon;

class ProductsChart extends ChartWidget
{
    protected ?string $heading = 'Products Supply';

    protected int|string|array $columnSpan = [
        'default' => 12,
        'md' => 6,
        'xl' => 6,
    ];

    protected function getData(): array
    {
        // Labels: months of the year
        $months = collect(range(1, 12))
            ->map(fn($m) => Carbon::create()->month($m)->format('M'))
            ->toArray();

        $supply = [];

        foreach (range(1, 12) as $month) {
            $year = now()->year;

            // Total quantity of all products created or updated in that month
            $supply[] = Product::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('quantity');
        }

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Supply',
                    'data' => $supply,
                    'borderColor' => '#4ade80',
                    'fill' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getHeight(): ?string
    {
        return '400px';
    }
}
