<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

trait HandleFlights
{
    public function flightInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Flights App?', true, true)) {
            $this->flightStubDir = __DIR__ . '/../../resources/install/flightsFiles';
            $this->generateFlightFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
                <<<ROUTES
            // Flights Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Flight\Flights::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/flights', App\Livewire\Flight\Flights::class)->name('admin.flights');
                Route::get('/airlines', App\Livewire\Flight\Airlines::class)->name('admin.airlines');
                Route::get('/delays', App\Livewire\Flight\Delays::class)->name('admin.delays');
                Route::get('/services', App\Livewire\Flight\Services::class)->name('admin.services');
                Route::get('/registrations', App\Livewire\Flight\Registrations::class)->name('admin.registrations');
                Route::get('/schedules', App\Livewire\Flight\Schedules::class)->name('admin.schedules');
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

    public function generateFlightFiles()
    {
        $files = $this->filesystem->allFiles($this->flightStubDir, true);
        foreach ($files as $file) {
            $filePath = $this->replace(Str::replaceLast('.stub', '', $file->getRelativePathname()));
            $fileDir = $this->replace($file->getRelativePath());

            if ($fileDir) {
                $this->filesystem->ensureDirectoryExists($fileDir);
            }
            $this->filesystem->put($filePath, $this->replace($file->getContents()));
            $this->warn('Generated file: <info>' . $filePath . '</info>');
        }
    }
}