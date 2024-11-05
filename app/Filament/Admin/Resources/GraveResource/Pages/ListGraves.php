<?php

namespace App\Filament\Admin\Resources\GraveResource\Pages;

use App\Filament\Admin\Resources\GraveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGraves extends ListRecords
{
    protected static string $resource = GraveResource::class;

    protected static ?string $title = 'List kuburan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
