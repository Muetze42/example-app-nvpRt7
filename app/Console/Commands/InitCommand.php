<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create empty example models, migrations and Nova resources.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $models = [
            'Car',
            'Comment',
            'Customer',
            'Driver',
            'Invoice',
            'Manufacturer',
            'Mechanic',
            'Order',
            'Page',
            'Post',
            'Project',
            'Setting',
            'Spare',
        ];

        foreach ($models as $model) {
            $this->call('make:model', [
                'name' => $model,
                '-m'   => true,
            ]);
            $this->call('nova:resource', [
                'name' =>$model,
            ]);
        }
    }
}
