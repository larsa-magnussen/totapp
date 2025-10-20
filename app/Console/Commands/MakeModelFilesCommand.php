<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeModelFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:all { name : Name of the model }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all needed files for a new model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        Artisan::call('make:model', [
            'name' => $name,
            '--migration' => true,
            '--factory' => true,
            '--policy' => true,
        ]);

        Artisan::call('make:test', ['name' => 'Tests/Unit/' . $name . 'Test']);
        Artisan::call('make:test', ['name' => $name . 'ApiTest']);
        Artisan::call('make:resource', ['name' => $name . 'Resource']);
        Artisan::call('make:controller', ['name' => 'Api/' . $name . 'Controller', '--api' => true]);

    }
}
