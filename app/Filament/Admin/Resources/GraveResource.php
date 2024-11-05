<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Role;
use App\Filament\Admin\Resources\GraveResource\Pages;
use App\Filament\Admin\Resources\GraveResource\RelationManagers;
use App\Models\Grave;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                        fn(string $search): array => User::where('role', Role::Client)->where('name', 'like', "%{$search}%")
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->name('Nama')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Admin kuburan')->searchable()->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'edit' => Pages\EditGrave::route('/{record}/edit'),
        ];
    }
}
