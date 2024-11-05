<?php

namespace App\Filament\Admin\Resources\GraveResource\Pages;

use App\Filament\Admin\Resources\GraveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGrave extends CreateRecord
{
    protected static string $resource = GraveResource::class;

    protected static ?string $title = 'Tambah kuburan';
}
