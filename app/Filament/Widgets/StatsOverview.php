<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $stats = [];

        $userRole = auth()->user()->getRoleNames()->first();

        if ($userRole === 'super_admin') {
            $categoryData = Category::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $courseData = Course::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $orderData = Order::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $promotionData = Promotion::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $serviceData = Service::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $userData = User::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();
        } elseif ($userRole === 'promotion') {
            $promotionData = Promotion::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $orderData = Order::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();
        } elseif ($userRole === 'worker') {
            $serviceData = Service::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $courseData = Course::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();

            $orderData = Order::whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->pluck('count', 'date')
                ->toArray();
        }

        $dates = [];
        $categoryValues = [];
        $courseValues = [];
        $orderValues = [];
        $promotionValues = [];
        $serviceValues = [];
        $userValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = $date;
            $categoryValues[] = $categoryData[$date] ?? 0;
            $courseValues[] = $courseData[$date] ?? 0;
            $orderValues[] = $orderData[$date] ?? 0;
            $promotionValues[] = $promotionData[$date] ?? 0;
            $serviceValues[] = $serviceData[$date] ?? 0;
            $userValues[] = $userData[$date] ?? 0;
        }

        if ($userRole === 'super_admin' || $userRole === 'promotion' || $userRole === 'worker') {
            $stats[] = Stat::make('Order Growth', array_sum($orderValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($orderValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('order', 'OrderResource')",
                ]);
        }

        if ($userRole === 'super_admin' || $userRole === 'promotion') {
            $stats[] = Stat::make('Promotion Growth', array_sum($promotionValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($promotionValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('promotion', 'PromotionResource')",
                ]);
        }

        if ($userRole === 'super_admin' || $userRole === 'worker') {
            $stats[] = Stat::make('Service Growth', array_sum($serviceValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($serviceValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('service', 'ServiceResource')",
                ]);
        }

        if ($userRole === 'super_admin' || $userRole === 'worker') {
            $stats[] = Stat::make('Course Growth', array_sum($courseValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($courseValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('course', 'CourseResource')",
                ]);
        }

        if ($userRole === 'super_admin') {
            $stats[] = Stat::make('Category Growth', array_sum($categoryValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($categoryValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('category', 'CategoryResource')",
                ]);
        }

        if ($userRole === 'super_admin') {
            $stats[] = Stat::make('User Growth', array_sum($userValues))
                ->description('7 days growth')
                ->color('primary')
                ->chart($userValues)
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('user', 'UserResource')",
                ]);
        }

        if ($userRole === 'super_admin') {
            $totalRevenue = Order::with(['service', 'course'])->whereNot('status', 'cancel')
                ->get()
                ->sum(function ($order) {
                    return $order->service->price ?? $order->course->price ?? 0;
                });

            $stats[] = Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total Revenue')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('order', 'OrderResource')",
                ]);

            return $stats;
        }

        if ($userRole === 'promotion') {
            $totalRevenue = Order::with(['service', 'course'])->where('status', 'done')->whereNot('status', 'cancel')
                ->get()
                ->sum(function ($order) {
                    return $order->service->price ?? $order->course->price ?? 0;
                });

            $promotionRevenue = $totalRevenue * 0.1;

            $stats[] = Stat::make('Total Revenue', 'Rp ' . number_format($promotionRevenue, 0, ',', '.'))
                ->description('Total Revenue (10%)')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('order', 'OrderResource')",
                ]);

            return $stats;
        }

        if ($userRole === 'worker') {
            $totalRevenue = Order::with(['service', 'course'])
                ->whereNot('status', 'cancel')
                ->get()
                ->sum(function ($order) {
                    if ($order->referral_code) {
                        return ($order->service->price ?? $order->course->price ?? 0) * 0.9;
                    }
                    return $order->service->price ?? $order->course->price ?? 0;
                });

            $stats[] = Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total Revenue')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "redirectToStats('order', 'OrderResource')",
                ]);

            return $stats;
        }
    }

    public function redirectToStats($type, $resource)
    {
        switch ($type) {
            case 'category':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            case 'course':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            case 'order':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            case 'promotion':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            case 'service':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            case 'user':
                $url = app("App\\Filament\\Resources\\{$resource}")->getUrl();
                break;
            default:
                $url = route('admin');
                break;
        }

        return redirect()->to($url);
    }
}
