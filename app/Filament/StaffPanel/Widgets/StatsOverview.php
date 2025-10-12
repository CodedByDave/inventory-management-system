<?php

namespace App\Filament\StaffPanel\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Sale;

class StatsOverview extends BaseWidget
{
    protected ?string $heading = 'Inventory Overview';

    protected function getStats(): array
    {
        // 📦 Inventory data
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('quantity', '<', 10)->count();
        $outOfStock = Product::where('quantity', '=', 0)->count();
        $totalBrands = Brand::count();

        // 💰 Sales data
        $totalSalesValue = Sale::sum('total_price'); // total revenue
        $totalItemsSold = Sale::sum('quantity');     // total sold units

        return [

            Stat::make('Total Products', number_format($totalProducts))
                ->description('All items available in inventory')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary')
                ->extraAttributes(['title' => 'Total number of products in the system']),

            // ⚠️ Low Stock
            Stat::make('Low Stock Items', number_format($lowStockProducts))
                ->description('Products below stock threshold')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->extraAttributes(['title' => 'Items with less than 10 remaining']),

            Stat::make('Out of Stock', number_format($outOfStock))
                ->description('Products currently unavailable')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->extraAttributes(['title' => 'Products that need restocking']),

            Stat::make('Total Brands', number_format($totalBrands))
                ->description('Registered suppliers and brands')
                ->descriptionIcon('heroicon-o-tag')
                ->color('info')
                ->extraAttributes(['title' => 'Brands linked to product categories']),

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

    // Responsive layout across screen sizes
    protected int|string|array $columnSpan = [
        'default' => 12,
        'md' => 12,
        'xl' => 12,
    ];
}
