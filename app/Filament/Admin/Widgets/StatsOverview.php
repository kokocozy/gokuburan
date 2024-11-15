<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Corpse;
use App\Models\Grave;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayDeathCount = Corpse::whereDate('created_at', now()->today())->count();
        $yesterdayDeathCount = Corpse::whereDate('created_at', now()->subDay()->toDateString())->count();

        if ($todayDeathCount === $yesterdayDeathCount) {
            $deathCountTrend = 'balance';
            $deathCountDifference = 0;
            $deathTrendIcon = '';
            $deathTrendColor = '';
        } elseif ($todayDeathCount > $yesterdayDeathCount) {
            $deathCountTrend = 'increase';
            $deathCountDifference = $todayDeathCount - $yesterdayDeathCount;
            $deathTrendIcon = 'heroicon-m-arrow-trending-up';
            $deathTrendColor = 'success';
        } else {
            $deathCountTrend = 'decrease';
            $deathCountDifference = $yesterdayDeathCount - $todayDeathCount;
            $deathTrendIcon = 'heroicon-m-arrow-trending-down';
            $deathTrendColor = 'danger';
        }

        return [
            Stat::make('Kematian hari ini', $todayDeathCount)
                ->description("{$deathCountDifference} {$deathCountTrend}")
                ->descriptionIcon($deathTrendIcon)
                ->color($deathTrendColor),

            Stat::make('Mayit terdata', Corpse::count())
                ->description('*last update ' . now()),

            Stat::make('Kuburan terdata', Grave::count())
                ->description('*last update ' . now()),
        ];
    }
}
