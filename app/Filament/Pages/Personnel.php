<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Personnel extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.pages.personnel';

    protected static ?int $navigationSort = 90;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role == 'admin';
    }
}
