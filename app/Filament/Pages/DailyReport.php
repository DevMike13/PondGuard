<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class DailyReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static string $view = 'filament.pages.daily-report';

    protected static ?int $navigationSort = 70;
}