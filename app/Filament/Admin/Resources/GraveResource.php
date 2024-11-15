<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Role;
use App\Filament\Admin\Resources\GraveResource\Pages;
use App\Filament\Admin\Resources\GraveResource\RelationManagers;
use App\Forms\Components\LeafletMap;
use App\Infolists\Components\LeafletMap as LeafletMapEntry;
use App\Models\Grave;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class GraveResource extends Resource
{
    protected static ?string $model = Grave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kuburan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Admin')
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search): array => User::where(
                            'role',
                            Role::Client
                        )->where('name', 'like', "%{$search}%")
                            ->limit(5)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name)
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('address')
                    ->label('address')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('grave_layout')
                    ->label('Grave Layout')
                    ->directory('graves')
                    ->image()
                    ->maxSize(1024)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('gmaps_url')
                    ->label('gmaps_url')
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt')
                    ->required()
                    ->columnSpanFull()
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')
                    ->weight(FontWeight::Bold)
                    ->size(TextEntrySize::Large)
                    ->columnSpanFull(),
                LeafletMapEntry::make('coordinates')
                    ->label('Letak makam')
                    ->helperText('*click on the icon to see details.')
                    ->imageUrl(function (?Model $record) {
                        return $record->grave_layout;
                    })
                    ->coordinates(coordinates: function (?Model $record) {
                        $items = [];
                        foreach ($record->corpses as $key => $value) {
                            $items[] = [$value->lat, $value->lng, $value->name];
                        }

                        return $items;
                    })
                    ->columnSpanFull(),
                TextEntry::make('address')
                    ->formatStateUsing(fn(string $state): HtmlString => new HtmlString($state))
                    ->columnSpanFull(),
                TextEntry::make('gmaps_url')
                    ->url(url('gmaps_url'))
                    ->openUrlInNewTab()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Admin kuburan')->searchable()->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'index' => Pages\ListGraves::route('/'),
            'create' => Pages\CreateGrave::route('/create'),
            'view' => Pages\ViewGrave::route('/{record}'),
            'edit' => Pages\EditGrave::route('/{record}/edit'),
        ];
    }
}
