<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Carbon\Carbon;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?string $navigationLabel = 'Services';

    protected static ?string $slug = 'services';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationColor = 'primary';

    protected static bool $shouldRegisterNavigation = true;

    protected static bool $globalSearchable = true;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['user', 'category']);
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'User' => $record->user ? $record->user->name : 'N/A',
            'Category' => $record->category ? $record->category->name : 'N/A',
            'Description' => $record->description,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Service::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Details')
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
                            ->hidden(!Filament::auth()->user()->hasRole('super_admin')),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->required()
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->placeholder('Select a category')
                            ->columnSpanFull(!Filament::auth()->user()->hasRole('super_admin')),
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Enter the service title here'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull()
                            ->placeholder('Provide a detailed description of the service, including features, benefits, etc.'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->reactive()
                            ->columnSpanFull()
                            ->placeholder('Enter the price in IDR (e.g., 50000)'),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 4,
                        'lg' => 6,
                    ]),
                Forms\Components\Section::make('Upload Photo')
                    ->columns([
                        'default' => 'full',
                    ])
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Upload Photo')
                            ->required()
                            ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/webp', 'image/jfif'])
                            ->maxSize(1024)
                            ->directory('photos')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->panelAspectRatio('16:9')
                            ->panelLayout('integrated')
                            ->helperText('Upload a valid image file (jpg, jpeg, webp, jfif)')
                            ->reactive()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ]),
            ])
            ->columns([
                'default' => 'full',
                'sm' => 3,
                'md' => 6,
                'lg' => 9,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn(Service $query) => $query->where('user_id', Filament::auth()->id()))
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->extraImgAttributes(fn(Service $record): array => [
                        'alt' => "{$record->title} Photo",
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->color('primary')
                    ->badge()
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->color('primary')
                    ->badge()
                    ->icon('heroicon-o-tag')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR', 0, 'id')
                    ->sortable(),
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
                Tables\Filters\TrashedFilter::make()
                    ->columnSpan(2),
                Tables\Filters\SelectFilter::make('User')
                    ->relationship('user', 'name')
                    ->columnSpan(2),
                Tables\Filters\SelectFilter::make('Category')
                    ->relationship('category', 'name')
                    ->columnSpan(2),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], function (Builder $query, $date) {
                                $query->whereDate('created_at', '>=', $date);
                            })
                            ->when($data['created_until'], function (Builder $query, $date) {
                                $query->whereDate('created_at', '<=', $date);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })->columnSpan(2)->columns(1),
            ], FiltersLayout::Modal)
            ->actions([
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
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
