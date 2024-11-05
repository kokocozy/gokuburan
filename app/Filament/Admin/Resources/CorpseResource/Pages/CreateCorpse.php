<?php

namespace App\Filament\Admin\Resources\CorpseResource\Pages;

use App\Filament\Admin\Resources\CorpseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCorpse extends CreateRecord
{
    protected static string $resource = CorpseResource::class;

    protected static ?string $title = 'Tambah mayit';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['lat'] = $data['coordinates']['latitude'];
        $data['lng'] = $data['coordinates']['longitude'];
        $data['coordinates'] = "";

        return $data;
    }
}
