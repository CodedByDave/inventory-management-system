<?php

namespace App\Filament\StaffPanel\Resources\Products\Tables;

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
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                // ✅ CSV Import Button
                Action::make('importCsv')
                    ->label('Import CSV')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('csv_file')
                            ->label('Upload CSV File')
                            ->acceptedFileTypes(['text/csv'])
                            ->directory('imports')
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        $path = Storage::path($data['csv_file']);
                        $csv = Reader::createFromPath($path, 'r');
                        $csv->setHeaderOffset(0);
                        $records = $csv->getRecords();

                        DB::transaction(function () use ($records) {
                            foreach ($records as $record) {
                                // ✅ Convert category and brand names to IDs
                                $categoryId = null;
                                $brandId = null;

                                if (!empty($record['category_id'])) {
                                    $categoryId = Category::whereRaw('LOWER(name) = ?', [strtolower($record['category_id'])])->value('id');

                                    // Auto-create category if not found
                                    if (!$categoryId) {
                                        $categoryId = Category::create([
                                            'name' => $record['category_id'],
                                            'description' => 'Auto-created from CSV import.',
                                        ])->id;
                                    }
                                }

                                if (!empty($record['brand_id'])) {
                                    $brandId = Brand::whereRaw('LOWER(name) = ?', [strtolower($record['brand_id'])])->value('id');

                                    // Auto-create brand if not found
                                    if (!$brandId) {
                                        $brandId = Brand::create([
                                            'name' => $record['brand_id'],
                                            'description' => 'Auto-created from CSV import.',
                                            'category_id' => $categoryId,
                                        ])->id;
                                    }
                                }

                                // ✅ Insert or update product
                                Product::updateOrCreate(
                                    ['sku' => $record['sku'] ?? null],
                                    [
                                        'name'          => $record['name'] ?? '',
                                        'category_id'   => $categoryId,
                                        'brand_id'      => $brandId,
                                        'description'   => $record['description'] ?? '',
                                        'quantity'      => $record['quantity'] ?? 0,
                                        'unit'          => $record['unit'] ?? 'pcs',
                                        'price'         => $record['price'] ?? 0,
                                        'cost_price'    => $record['cost_price'] ?? 0,
                                        'reorder_level' => $record['reorder_level'] ?? 5,
                                        'status'        => $record['status'] ?? 'onstock',
                                    ]
                                );
                            }
                        });
                    })
                    ->successNotificationTitle('Products imported successfully!'),
            ]);
    }
}
