<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use Filament\Tables\Columns\BadgeColumn;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Card::make()
                ->schema([
                    TextInput::make('nim')->required()->unique(ignorable:fn($record)=> $record),
                    TextInput::make('nama')->required(),
                    Select::make('jurusan')->options([
                        'Teknologi Informasi'=> 'Teknologi Informasi',
                        'Teknik Sipil' => 'Teknik Sipil',
                        'Teknik Mesin' => 'Teknik Mesin' 
                        ]),
                ])
                ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')->sortable()->searchable(),
                TextColumn::make('nama')->sortable()->searchable(),
                BadgeColumn::make('jurusan')->sortable()->searchable()
                ->label('Jurusan')
                ->colors(['success'])
                ->enum([
                    'Teknologi Informasi'=> 'Teknologi Informasi',
                    'Teknik Sipil' => 'Teknik Sipil',
                    'Teknik Mesin' => 'Teknik Mesin'
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }    
}
