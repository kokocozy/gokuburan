<?php

namespace App\Filament\Admin\Resources\CorpseResource\Pages;

use App\Filament\Admin\Resources\CorpseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorpse extends EditRecord
{
    protected static string $resource = CorpseResource::class;

    protected static ?string $title = 'Edit mayit';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['lat'] = $data['coordinates']['latitude'];
        $data['lng'] = $data['coordinates']['longitude'];
        $data['coordinates'] = "";

        return $data;
    }
}
