<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            //Product Selection
            Select::make('product_id')
                ->label('Product')
                ->options(Product::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive(),

            //Quantity Input
            TextInput::make('quantity')
                ->label('Quantity Sold')
                ->numeric()
                ->minValue(1)
                ->required()
                ->reactive(),

            //Total Price (Auto)
            TextInput::make('total_price')
                ->label('Total Price (₱)')
                ->numeric()
                ->prefix('₱')
                ->readOnly()
                ->reactive()
                ->afterStateHydrated(function ($set, $get) {
                    // Recalculate on load (optional)
                    $product = Product::find($get('product_id'));
                    if ($product) {
                        $set('total_price', $product->price * ($get('quantity') ?? 1));
                    }
                })
                ->dehydrateStateUsing(function ($state, $get) {
                    // Save computed value to DB
                    $product = Product::find($get('product_id'));
                    return $product ? $product->price * ($get('quantity') ?? 1) : $state;
                }),

            //Date of Sale
            DatePicker::make('sold_at')
                ->label('Date Sold')
                ->default(now())
                ->required(),
        ]);
    }
}
