<?php

namespace App\Filament\Admin\Resources\CorpseResource\Pages;

use App\Filament\Admin\Resources\CorpseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorpses extends ListRecords
{
    protected static string $resource = CorpseResource::class;

    protected static ?string $title = 'List mayit';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
