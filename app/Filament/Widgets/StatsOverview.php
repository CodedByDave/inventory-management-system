<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $heading = 'Dashboard Overview';

    protected function getStats(): array
    {
        // 👥 User stats
        $totalUsers = User::count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        // 💰 Sales stats
        $totalSalesValue = Sale::sum('total_price');
        $totalItemsSold = Sale::sum('quantity');

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description('All registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->extraAttributes(['title' => 'All users in the system']),

            Stat::make('Inactive Users', number_format($inactiveUsers))
                ->description('Users who are inactive')
                ->descriptionIcon('heroicon-o-user-minus')
                ->color('danger')
                ->extraAttributes(['title' => 'Users with inactive status']),

            Stat::make('Total Sales', '₱' . number_format($totalSalesValue, 2))
                ->description('Overall revenue from all sales')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success')
                ->extraAttributes(['title' => 'Total sales revenue from completed transactions']),

            Stat::make('Total Items Sold', number_format($totalItemsSold))
                ->description('Total quantity of products sold')
                ->descriptionIcon('heroicon-o-cube')
                ->color('secondary')
                ->extraAttributes(['title' => 'Sum of all product quantities sold']),
        ];
    }

    protected int|string|array $columnSpan = [
        'default' => 12,
        'md' => 12,
        'xl' => 12,
    ];
}
