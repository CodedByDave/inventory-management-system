<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity Sold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('PHP', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('sold_at')
                    ->label('Date Sold')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
