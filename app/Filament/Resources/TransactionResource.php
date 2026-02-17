<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    // protected static ?string $navigationGroup = 'Financial';
    
    public static function getNavigationLabel(): string
    {
        return 'Manajemen Transaksi';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return null;
        /** @var \App\Models\User */
        // $user = auth()->user();
        // if (in_array($user->role, ['admin', 'super_admin', 'operator'])) {
        //     return (string) Transaction::where('status', 'pending')->count();
        // }
        // return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->role === 'wali_kelas') {
            $classRoom = $user->teachingClass;
            if ($classRoom) {
                $query->whereHas('user', function ($q) use ($classRoom) {
                    $q->where('class_room_id', $classRoom->id);
                });
            } else {
                return $query->whereRaw('1 = 0'); // No class assigned, show nothing
            }
        } elseif ($user->role === 'student') {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Student')
                    ->relationship('user', 'name', function (Builder $query) {
                        $user = auth()->user();
                        $query->where('role', 'student');
                        
                        if ($user->role === 'wali_kelas') {
                            $classRoom = $user->teachingClass;
                            if ($classRoom) {
                                $query->where('class_room_id', $classRoom->id);
                            } else {
                                $query->whereRaw('1 = 0');
                            }
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('saving_type_id')
                    ->relationship('savingType', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'deposit' => 'Deposit',
                        'withdrawal' => 'Withdrawal',
                    ])
                    ->required()
                    ->default('deposit'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->minValue(100),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->visible(fn () => in_array(auth()->user()->role, ['admin', 'super_admin', 'operator']))
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->maxDate(now()),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->disabled()
                    ->visible(fn () => in_array(auth()->user()->role, ['admin', 'super_admin', 'operator']) && fn ($get) => $get('status') === 'approved'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.classRoom.name')
                    ->label('Class')
                    ->sortable(),
                Tables\Columns\TextColumn::make('savingType.name')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'deposit' => 'success',
                        'withdrawal' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Approved By')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn (Transaction $record) => $record->status === 'pending' || in_array(auth()->user()->role, ['admin', 'super_admin'])),
                    Tables\Actions\Action::make('approve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Transaction $record) {
                            $record->update([
                                'status' => 'approved',
                                'approved_by' => auth()->id(),
                            ]);
                            Notification::make()
                                ->title('Transaction approved successfully')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Transaction $record) => $record->status === 'pending' && in_array(auth()->user()->role, ['admin', 'super_admin', 'operator'])),
                    Tables\Actions\Action::make('reject')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Transaction $record) {
                            $record->update([
                                'status' => 'rejected',
                                'approved_by' => auth()->id(),
                            ]);
                            Notification::make()
                                ->title('Transaction rejected')
                                ->danger()
                                ->send();
                        })
                        ->visible(fn (Transaction $record) => $record->status === 'pending' && in_array(auth()->user()->role, ['admin', 'super_admin', 'operator'])),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'approved',
                                        'approved_by' => auth()->id(),
                                    ]);
                                }
                            });
                            Notification::make()
                                ->title('Selected transactions approved')
                                ->success()
                                ->send();
                        })
                        ->visible(fn () => in_array(auth()->user()->role, ['admin', 'super_admin', 'operator'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
