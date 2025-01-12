<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Filament\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationLabel = 'Promotions';

    protected static ?string $slug = 'promotions';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationColor = 'primary';

    protected static bool $shouldRegisterNavigation = true;

    protected static bool $globalSearchable = true;

    protected static ?string $recordTitleAttribute = 'code';

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with('user');
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->code;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'User' => $record->user ? $record->user->name : 'N/A',
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Promotion::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Promotion Details')
                    ->columns([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->required()
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->default(Filament::auth()->id())
                            ->hidden(!Filament::auth()->user()->hasRole('super_admin'))
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('code')
                            ->label('Referral Code')
                            ->disabled()
                            ->placeholder('The referral code will be generated automatically')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 4,
                        'lg' => 6,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->color('primary')
                    ->badge()
                    ->icon('heroicon-o-user')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Referral Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->color('danger')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->color('success')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->color('warning')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ], FiltersLayout::Modal)
            ->actions([
                Tables\Actions\Action::make('SalinLink')
                    ->label('Salin Link Refferal')
                    ->icon('heroicon-o-link')
                    ->color('success')
                    ->link()
                    ->extraAttributes(fn($record) => [
                        'onclick' => 'navigator.clipboard.writeText(`' . route('home', ['code' => $record->code]) . '`);',
                    ]),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'view' => Pages\ViewPromotion::route('/{record}'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
