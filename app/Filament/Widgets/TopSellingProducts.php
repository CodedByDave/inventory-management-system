<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class TopSellingProducts extends TableWidget
{
    protected static ?string $heading = 'Top Selling Products';

    protected int|string|array $columnSpan = [
        'default' => 12,
        'md' => 6,
        'xl' => 6,
    ];

    protected function getTableQuery(): Builder|Relation
    {
        return Product::query()
            ->withSum('sales', 'quantity')  // adds a column sales_sum_quantity
            ->orderByDesc('sales_sum_quantity')
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Product')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('brand.name')
                ->label('Brand')
                ->sortable(),

            Tables\Columns\TextColumn::make('sales_sum_quantity')
                ->label('Total Sold')
                ->sortable()
                ->alignEnd(),

            Tables\Columns\TextColumn::make('price')
                ->label('Unit Price')
                ->money('PHP', true)
                ->alignEnd(),
        ];
    }
}
