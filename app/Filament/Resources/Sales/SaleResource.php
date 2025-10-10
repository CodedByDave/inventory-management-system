<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\CreateSale;
use App\Filament\Resources\Sales\Pages\EditSale;
use App\Filament\Resources\Sales\Pages\ListSales;
use App\Filament\Resources\Sales\Schemas\SaleForm;
use App\Filament\Resources\Sales\Tables\SalesTable;
use App\Models\Sale;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SaleResource extends Resource
{
    // 🔗 I-link sa Sale model
    protected static ?string $model = Sale::class;

    // 🧭 Icon para sa sidebar navigation
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    // 📛 Gamitin ang product name bilang title sa record
    protected static ?string $recordTitleAttribute = 'product_id';

    public static function form(Schema $schema): Schema
    {
        return SaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
            'create' => CreateSale::route('/create'),
            'edit' => EditSale::route('/{record}/edit'),
        ];
    }

    // 🧩 Optional: Custom label para sa menu
    public static function getNavigationLabel(): string
    {
        return 'Sales Management';
    }

    // 🧩 Optional: Custom plural/singular name
    public static function getModelLabel(): string
    {
        return 'Sale';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sales';
    }
}
