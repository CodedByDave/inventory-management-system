<?php

namespace App\Providers\Filament;

use App\Filament\StaffPanel\Widgets\StatsOverview;
use App\Filament\StaffPanel\Widgets\StaffSalesChart;
use App\Filament\Widgets\SalesChart;
use App\Models\Sale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Actions\Action;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('staff') // unique panel ID
            ->brandName('Staff Panel')
            ->path('staff')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->widgets([
                StatsOverview::class,
                SalesChart::class,
            ])
            ->discoverResources(
                in: app_path('Filament/StaffPanel/Resources'),
                for: 'App\Filament\StaffPanel\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/StaffPanel/Pages'),
                for: 'App\Filament\StaffPanel\Pages'
            )
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/StaffPanel/Widgets'),
                for: 'App\Filament\StaffPanel\Widgets'
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                Action::make('logout')
                    ->label('Logout')
                    ->icon('heroicon-o-arrow-right-start-on-rectangle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Logout')
                    ->modalDescription('Are you sure you want to log out?')
                    ->modalSubmitActionLabel('Yes, log me out')
                    ->action(function () {
                        Auth::logout();
                        session()->invalidate();
                        session()->regenerateToken();

                        session()->flash('logout_success', true);

                        return redirect()->route('login'); // your staff login route
                    }),
            ]);
    }
}
