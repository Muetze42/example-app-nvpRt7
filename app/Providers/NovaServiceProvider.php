<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Http\Request;
use App\Nova\Resources\Car;
use App\Nova\Resources\Comment;
use App\Nova\Resources\Customer;
use App\Nova\Resources\Driver;
use App\Nova\Resources\Invoice;
use App\Nova\Resources\Manufacturer;
use App\Nova\Resources\Mechanic;
use App\Nova\Resources\Order;
use App\Nova\Resources\Page;
use App\Nova\Resources\Post;
use App\Nova\Resources\Setting;
use App\Nova\Resources\Spare;
use App\Nova\Resources\User;

use NormanHuth\NovaMenu\MenuCard;
use NormanHuth\NovaMenu\MenuSection;
use NormanHuth\NovaMenu\MenuGroup;
use NormanHuth\NovaMenu\MenuItem;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * The Main Menu Example.
     *
     * @return void
     */
    protected function mainMenu(): void
    {
        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)
                    ->icon('chart-bar')->elemClasses('bg-slate-300 dark:bg-slate-950'),

                MenuSection::make('Fleet', [
                    MenuItem::resource(Car::class)
                        ->faIcon('fa-solid fa-car')
                        ->asLabel()
                        ->iconClasses('fa-fw'),
                    MenuItem::resource(Driver::class)
                        ->faIcon('fa-solid fa-id-card')
                        ->asLabel()
                        ->iconClasses('fa-fw'),
                    MenuItem::resource(Manufacturer::class)
                        ->faIcon('fa-solid fa-industry')
                        ->asLabel()
                        ->iconClasses('fa-fw'),
                    MenuItem::resource(Mechanic::class)
                        ->faIcon('fa-solid fa-wrench')
                        ->asLabel()
                        ->iconClasses('fa-fw'),
                ])->imageIcon(asset('assets/pngwing.com.png'))->collapsable(),

                MenuSection::make('Customers', [
                    MenuItem::resource(Order::class)
                        ->faIcon('fa-solid fa-file-import')
                        ->iconClasses(['fa-fw', 'customers']),
                    MenuItem::resource(Invoice::class)
                        ->faIcon('fa-solid fa-file-invoice-dollar')
                        ->iconClasses(['fa-fw', 'customers']),
                    MenuItem::resource(Customer::class)
                        ->faIcon('fa-solid fa-user')
                        ->iconClasses(['fa-fw', 'customers']),
                ])->faIcon('fa-solid fa-users')->collapsable(),

                MenuCard::make('info')
                    ->view('news', ['name' => $request->user()->name])
                    ->addClasses(['text-center'])
                    ->rounded(),
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        $this->mainMenu();
        $this->footer();
    }

    /**
     * Example App Footer.
     *
     * @return void
     */
    protected function footer(): void
    {
        Nova::footer(function ($request) {
            return Blade::render('
            <p class="text-center text-base mb-4">Example App for
                <a class="link-default" href="https://github.com/Muetze42/nova-menu" target="_blank">norman-huth/nova-menu</a> and
                <a class="link-default" href="https://github.com/Muetze42/norman-huth-nova-resource-card" target="_blank">norman-huth/norman-huth-nova-resource-card</a> by
                <a class="link-default" href="https://huth.it/" target="_blank">Norman Huth</a>
            </p>
            <p class="text-center">Powered by <a target="_blank" class="link-default" href="https://nova.laravel.com">Laravel Nova</a> · v{!! $version !!}</p>
            <p class="text-center">&copy; {!! $year !!} Laravel LLC &middot; by Taylor Otwell and David Hemphill.</p>
        ', [
                'version' => Nova::version(),
                'year' => date('Y'),
            ]);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
