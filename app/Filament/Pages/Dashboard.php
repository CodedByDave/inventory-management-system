<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ProductsChart;
use Filament\Pages\Page;
use BackedEnum;
use App\Filament\Widgets\StatsOverview;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    // Remove static here
    protected string $view = 'filament.pages.dashboard';

    // Add this method to display widgets
    protected function getWidgets(): array
    {
        return [
            StatsOverview::class,
            ProductsChart::class,
        ];
    }
}
