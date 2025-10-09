<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $lowStockProducts = Product::where('quantity', '<', 10)->count();

        return [

            // User Stats Cards
            Stat::make('Total Users', $totalUsers)
                ->description('All users in the system')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Inactive Users', $inactiveUsers)
                ->description('Inactive accounts')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),


            Stat::make('Low Stock Products', $lowStockProducts) // Placeholder value
                ->description('Products low in stock')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}
