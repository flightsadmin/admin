<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;

trait HandleSchedule
{
    public function scheduleInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install SChedule App?', true, true)) {
            $this->permStubDir = __DIR__ . '/../../resources/install/permissions';

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
                <<<ROUTES
            // Schedule Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Schedules::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/schedules', App\Livewire\Schedules::class)->name('admin.schedules');
            });
            ROUTES;

            $fileHook = "//Route Hooks - Do not delete//";

            if (!Str::contains($updatedData, trim($spatieRoutes))) {
                $UserModelContents = str_replace($fileHook, $fileHook . PHP_EOL . $spatieRoutes, $updatedData);
                $this->filesystem->put($routeFile, $UserModelContents);
                $this->warn($routeFile . ' Updated');
            }
        }
    }
}