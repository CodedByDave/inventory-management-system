<?php

namespace App\Filament\StaffPanel\Resources\Products\Pages;

use App\Filament\StaffPanel\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
