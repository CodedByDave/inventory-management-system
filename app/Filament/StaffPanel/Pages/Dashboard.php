<?php

namespace App\Filament\StaffPanel\Pages;

use App\Filament\Widgets\SalesChart;
use Filament\Pages\Page;
use BackedEnum;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament-panels::filament.staff-panel.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            SalesChart::class,
        ];
    }
}
