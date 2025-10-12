<?php

namespace App\Filament\StaffPanel\Resources\Sales;

use App\Filament\StaffPanel\Resources\Sales\Pages\CreateSales;
use App\Filament\StaffPanel\Resources\Sales\Pages\EditSales;
use App\Filament\StaffPanel\Resources\Sales\Pages\ListSales;
use App\Filament\StaffPanel\Resources\Sales\Schemas\SalesForm;
use App\Filament\StaffPanel\Resources\Sales\Tables\SalesTable;
use App\Models\Sale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalesResource extends Resource
{

    protected static ?string $model = Sale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static ?string $recordTitleAttribute = 'product_id';

    public static function form(Schema $schema): Schema
    {
        return SalesForm::configure($schema);
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
            'create' => CreateSales::route('/create'),
            'edit' => EditSales::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Sales Management';
    }

    public static function getModelLabel(): string
    {
        return 'Sale';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sales';
    }
}
