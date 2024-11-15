<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\StatsOverview;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends Page
{
    protected static string $view = 'filament.admin.pages.dashboard';

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
