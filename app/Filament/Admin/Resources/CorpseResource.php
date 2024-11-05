<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CorpseResource\Pages;
use App\Filament\Admin\Resources\CorpseResource\RelationManagers;
use App\Forms\Components\LeafletMap;
use App\Models\Corpse;
use App\Models\Grave;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;
use Illuminate\Database\Eloquent\Model;

class CorpseResource extends Resource
{
    protected static ?string $model = Corpse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Mayit';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                Select::make('grave_id')
                    ->label('Kuburan')
                    ->options(Grave::all()->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Livewire $livewire, Set $set, $state) {
                        $graveLayout = Grave::where('id', $state)->first();
                        $set('grave_layout', $graveLayout->grave_layout);

                        $livewire->dispatch('change-map-leaflet', $graveLayout->grave_layout);
                    })
                    ->required()
                    ->columnSpanFull()
                    ->searchable(),
                LeafletMap::make('coordinates')
                    ->label('Letak makam')
                    ->imageUrl(function (?Model $record) {
                        return $record->grave->grave_layout ?? "";
                    })
                    ->coordinates(coordinates: function (?Model $record) {
                        if ($record && isset($record->lat) && isset($record->lng)) {
                            return [
                                [$record->lat, $record->lng]
                            ];
                        }

                        return [];
                    })
                    ->required()
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->sortable()->searchable(),
                TextColumn::make('grave.name')->label('Kuburan')->searchable()->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCorpses::route('/'),
            'create' => Pages\CreateCorpse::route('/create'),
            'edit' => Pages\EditCorpse::route('/{record}/edit'),
        ];
    }
}
