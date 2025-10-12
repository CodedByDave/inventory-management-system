<?php

namespace App\Filament\StaffPanel\Resources\Sales\Pages;

use App\Filament\StaffPanel\Resources\Sales\SalesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSales extends EditRecord
{
    protected static string $resource = SalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
