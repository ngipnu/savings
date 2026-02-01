<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'My Transactions';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->readOnly(),
                Forms\Components\TextInput::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->readOnly(),
                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->prefix('IDR')
                    ->numeric()
                    ->readOnly(),
                Forms\Components\TextInput::make('savingType.name')
                    ->label('Saving Type')
                    ->readOnly(),
                Forms\Components\TextInput::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->readOnly(),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'deposit' => 'success',
                        'withdrawal' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('savingType.name')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->limit(30),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
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
            'index' => Pages\ListTransactions::route('/'),
        ];
    }
}
