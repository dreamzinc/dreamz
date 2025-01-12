<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $slug = 'orders';

    protected static ?string $navigationGroup = 'Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationColor = 'primary';

    protected static bool $shouldRegisterNavigation = true;

    protected static bool $globalSearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['service', 'course']);
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Service' => $record->service ? $record->service->title : 'N/A',
            'Course' => $record->course ? $record->course->title : 'N/A',
            'Whatsapp Number' => $record->whatsapp_number,
            'Deadline' => $record->deadline,
            'Description' => $record->description,
            'Status' => $record->status,
            'Order Code' => $record->order_code,
            'Referral Code' => $record->referral_code,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Order::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->columns([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->label('Service')
                            ->relationship('service', 'title')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->placeholder('Select a service'),
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'title')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->placeholder('Select a course'),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter the customer name here'),
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('WhatsApp Number')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter the WhatsApp number here'),
                        Forms\Components\DateTimePicker::make('deadline')
                            ->label('Deadline')
                            ->required()
                            ->placeholder('Select a deadline date and time'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(Order::statusOptions())
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->default(Order::STATUS_PENDING)
                            ->placeholder('Select order status'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull()
                            ->placeholder('Enter a detailed description of the order'),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 4,
                        'lg' => 6,
                    ]),
                Forms\Components\Section::make('Additional Information')
                    ->columns([
                        'default' => 'full',
                        'sm' => 2,
                        'md' => 2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('order_code')
                            ->label('Order Code')
                            ->disabled()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Order code will be generated automatically'),
                        Forms\Components\TextInput::make('referral_code')
                            ->label('Referral Code')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Enter the referral code here (if any)'),
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
            ->columns([
                Tables\Columns\TextColumn::make('service.title')
                    ->label('Service')
                    ->color('primary')
                    ->badge()
                    ->icon('heroicon-o-square-3-stack-3d')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        $price = $record->service->price ?? 0;
                        $title = Str::limit($state, 20);
                        return '<span>' . $title . '</span><br><span>Rp ' . number_format($price, 2, ',', '.') . '</span>';
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->color('primary')
                    ->badge()
                    ->icon('heroicon-o-book-open')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(function ($state, $record) {
                        $price = $record->course->price ?? 0;
                        $title = Str::limit($state, 20);
                        return '<span>' . $title . '</span><br><span>- Rp ' . number_format($price, 2, ',', '.') . '</span>';
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'gray',
                        'progress' => 'warning',
                        'cancel' => 'danger',
                        'done' => 'success',
                    }),
                Tables\Columns\TextColumn::make('order_code')
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('Service')
                    ->relationship('service', 'title')
                    ->columnSpan(2),
                Tables\Filters\SelectFilter::make('Course')
                    ->relationship('course', 'title')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
