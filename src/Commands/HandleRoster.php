<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

trait HandleRoster
{
    public function rosterInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Roster App?', true, true)) {
            $this->permStubDir = __DIR__ . '/../../resources/install/rostersFiles';
            $this->generateRosterFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
            <<<ROUTES
            // Roster Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/rosters', App\Livewire\Rosters::class)->name('admin.rosters');
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
    public function generateRosterFiles()
    {
        $files = $this->filesystem->allFiles($this->permStubDir, true);
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