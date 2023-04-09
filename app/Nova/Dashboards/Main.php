<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboards\Main as Dashboard;
use NormanHuth\NovaResourceCard\NovaResourceCard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            (new NovaResourceCard(\App\Nova\Resources\User::class))->addResourceCardClasses(['my-class', 'p-2']),
            (new NovaResourceCard(\App\Nova\Resources\CardUser::class))->width('1/2'),
        ];
    }
}
