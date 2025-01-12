<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query),
            'week' => Tab::make()
                ->badge(fn() => $this->getCountBadge('week'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            'month' => Tab::make()
                ->badge(fn() => $this->getCountBadge('month'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', now()->month)),
            'year' => Tab::make()
                ->badge(fn() => $this->getCountBadge('year'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereYear('created_at', now()->year)),
        ];
    }

    public static function getCountBadge($period = null): int
    {
        $query = Order::query();

        if ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        return $query->count();
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'active';
    }
}
