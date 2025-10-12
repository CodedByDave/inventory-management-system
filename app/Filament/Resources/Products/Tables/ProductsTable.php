<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->toggleable(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),

                TextColumn::make('unit')
                    ->label('Unit')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('PHP', true)
                    ->sortable(),

                TextColumn::make('cost_price')
                    ->label('Cost Price')
                    ->money('PHP', true)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('reorder_level')
                    ->label('Reorder Level')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'danger' => 'lowstock',
                        'success' => 'onstock',
                    ])
                    ->label('Status'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'lowstock' => 'Low Stock',
                        'onstock' => 'On Stock',
                    ]),
                ]);
    }
}
