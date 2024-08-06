<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Dosen;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DosenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DosenResource\RelationManagers;

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                     TextInput::make('nip')->required()->unique(ignorable:fn ($record)=> $record),
                     TextInput::make('nama')->required(),
                     Select::make('jabatan')->options([
                            'Direktur' => 'Direktur',
                            'Kajur' => 'Kajur',
                            'Kaprodi' => 'Kaprodi'
                        ]),   
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')->sortable()->searchable(),
                TextColumn::make('nama')->sortable()->searchable(),
                BadgeColumn::make('jabatan')->sortable()->searchable()
                    ->label('Jabatan')
                    ->colors(['success'])
                    ->enum([
                        'Direktur' => 'Direktur',
                        'Kajur' => 'Kajur',
                        'Kaprodi' => 'Kaprodi'
                    ])
            ])  
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDosens::route('/'),
            'create' => Pages\CreateDosen::route('/create'),
            'edit' => Pages\EditDosen::route('/{record}/edit'),
        ];
    }    
}
