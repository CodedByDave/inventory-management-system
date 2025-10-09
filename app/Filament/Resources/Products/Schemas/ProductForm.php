<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // 🏷 Product Name
            TextInput::make('name')
                ->label('Product Name')
                ->required()
                ->maxLength(255),

            // 🔢 SKU / Code
            TextInput::make('sku')
                ->label('SKU / Code')
                ->unique('products', 'sku', ignoreRecord: true)
                ->required()
                ->maxLength(100),

            // 📂 Category
            Select::make('category_id')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->reactive() // Make it reactive so brand updates when category changes
                ->afterStateUpdated(fn($state, callable $set) => $set('brand_id', null)),

            Select::make('brand_id')
                ->label('Brand / Supplier')
                ->options(function (callable $get) {
                    $categoryId = $get('category_id');
                    if (!$categoryId) {
                        return Brand::pluck('name', 'id'); // Default all brands if no category selected
                    }
                    // Filter brands by category (you need a pivot table or category_id in brands)
                    return Brand::where('category_id', $categoryId)->pluck('name', 'id');
                })
                ->searchable()
                ->preload()
                ->required(),

            // 📝 Description
            Textarea::make('description')
                ->label('Description')
                ->rows(3)
                ->maxLength(1000)
                ->columnSpanFull(),

            // 📦 Quantity
            TextInput::make('quantity')
                ->label('Quantity / Stock')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

            // 📏 Unit
            Select::make('unit')
                ->label('Unit')
                ->options([
                    'pcs' => 'Pieces',
                    'box' => 'Box',
                    'kg'  => 'Kilogram',
                    'g'   => 'Gram',
                    'l'   => 'Liter',
                    'ml'  => 'Milliliter',
                ])
                ->required(),

            TextInput::make('price')
                ->label('Selling Price')
                ->numeric()
                ->minValue(0)
                ->step(0.01) // Allow decimal values
                ->prefix('₱')
                ->required(),

            // 💵 Cost Price - FIXED
            TextInput::make('cost_price')
                ->label('Cost Price')
                ->numeric()
                ->minValue(0)
                ->step(0.01) // Allow decimal values
                ->default(0.00) // Add default value
                ->prefix('₱')
                ->required(),

            // ⚠ Reorder Level
            TextInput::make('reorder_level')
                ->label('Reorder Level')
                ->numeric()
                ->minValue(0)
                ->default(5),

            // Status - Make sure values match database enum exactly
            Select::make('status')
                ->label('Status')
                ->options([
                    'lowstock' => 'Low Stock',
                    'onstock'  => 'On Stock', // Must match 'onstock' in database
                ])
                ->default('onstock')
                ->required(),

            // Product Image
            FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->directory('products')
                ->maxSize(2048)
                ->columnSpanFull(),
        ]);
    }
}
