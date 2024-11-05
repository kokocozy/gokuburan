<?php

namespace App\Filament\Admin\Resources\GraveResource\Pages;

use App\Filament\Admin\Resources\GraveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrave extends EditRecord
{
    protected static string $resource = GraveResource::class;

    // protected static string $view = 'filament.admin.resources.grave-resource.pages.edit-grave';

    protected static ?string $title = 'Edit kuburan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
