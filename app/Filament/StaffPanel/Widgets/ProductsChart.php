<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected ?string $heading = 'Sales Over Last 6 Months';

    protected function getType(): string
    {
        return 'bar';
    }

    protected int|string|array $columnSpan = [
        'default' => 12,
        'md' => 6,
        'xl' => 6,
    ];

    protected function getData(): array
    {
        // Get the last 6 months
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('M Y'));
        }

        // Get sales totals per month
        $salesData = Sale::query()
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->selectRaw('SUM(total_price) as total, MONTH(created_at) as month, YEAR(created_at) as year')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn($sale) => Carbon::createFromDate($sale->year, $sale->month, 1)->format('M Y'))
            ->map(fn($sale) => round($sale->total, 2));

        // Fill in months with 0 if no sales
        $salesValues = $months->map(fn($month) => $salesData[$month] ?? 0)->toArray();

        return [
            'labels' => $months->toArray(),
            'datasets' => [
                [
                    'label' => 'Sales (₱)',
                    'data' => $salesValues,
                    'backgroundColor' => '#f59e0b', // amber
                ],
            ],
        ];
    }
}
