<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

trait FileHandler
{
    public function spatiePermissionsInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Spatie Laravel Permission?', true, true)) {
            $this->permStubDir = __DIR__ . '/../../resources/install/permissions';
            $this->generatePermissionFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes = 
            <<<ROUTES
            // Admin Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Flights::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/flights', App\Livewire\Flights::class)->name('admin.flights');
                Route::get('/airlines', App\Livewire\Airlines::class)->name('admin.airlines');
                Route::get('/delays', App\Livewire\Delays::class)->name('admin.delays');
                Route::get('/services', App\Livewire\Services::class)->name('admin.services');
                Route::get('/registrations', App\Livewire\Registrations::class)->name('admin.registrations');
                Route::get('/schedules', App\Livewire\Schedules::class)->name('admin.schedules');
                Route::get('/users', App\Livewire\Users::class)->name('admin.users');
                Route::get('/roles', App\Livewire\Roles::class)->name('admin.roles');
                Route::get('/permissions', App\Livewire\Permissions::class)->name('admin.permissions');
                Route::get('/settings', App\Livewire\Settings::class)->name('admin.settings');
            });
            ROUTES;
            
            $fileHook = "//Route Hooks - Do not delete//";

            if (!Str::contains($updatedData, trim($spatieRoutes))) {
                $UserModelContents = str_replace($fileHook, $fileHook . PHP_EOL . $spatieRoutes, $updatedData);
                $this->filesystem->put($routeFile, $UserModelContents);
                $this->warn($routeFile . ' Updated');
            }

            //Updating NavBar
            $layoutsFile = base_path('resources/views/components/layouts/includes/header.blade.php');
            $layoutsData = $this->filesystem->get($layoutsFile);
            $spatieNavs  =
            <<<NAV
                                    @role('super-admin|admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route(config('admin.adminRoute')) }}">{{ ucwords(config('admin.adminRoute'))}}</a>
                                    </li>
                                    @endrole
            NAV;
            $spatieFileHook = "<!--Nav Bar Hooks - Do not delete!!-->";

            if (!Str::contains($layoutsData, $spatieNavs)) {
                $UserModelContents = str_replace($spatieFileHook, $spatieFileHook . PHP_EOL . $spatieNavs, $layoutsData);
                $this->filesystem->put($layoutsFile, $UserModelContents);
                $this->warn($layoutsFile . ' Updated');
            }

            //Updating Kernel
            $kernelFile = app_path('Http/Kernel.php');
            $kernelData = $this->filesystem->get($kernelFile);
            $kerneltemStub = "\t\t//Spatie Permission Traits\n\t\t'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class, \n\t\t'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class, \n\t\t'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,\n\t\t//End Spatie Permission Trait";
            $kernelItemHook = (version_compare(app()->version(), '10.0.0', '>=')) ? 'protected $middlewareAliases = [' : 'protected $routeMiddleware = [';

            if (!Str::contains($kernelData, $kerneltemStub)) {
                $KernelContents = str_replace($kernelItemHook, $kernelItemHook . PHP_EOL . $kerneltemStub, $kernelData);
                $this->filesystem->put($kernelFile, $KernelContents);
                $this->warn('<info>' . $kernelFile . '</info> Updated');
            }

            // Updating User Model
            $userModelFile = app_path('Models/User.php');
            $fileData = $this->filesystem->get($userModelFile);
            $modelReplacements = [
                "class User extends Authenticatable\n{" => "\tuse HasRoles, SoftDeletes;",
                "namespace App\Models;\n"               => "use Spatie\Permission\Traits\HasRoles;\nuse Illuminate\Database\Eloquent\SoftDeletes;",
                "protected \$fillable = ["              => "\t\t'phone',\n\t\t'photo',\n\t\t'title',",
            ];
            
            foreach ($modelReplacements as $key => $value) {
                if (!Str::contains($fileData, $value)) {
                    $fileData = str_replace($key, $key . PHP_EOL . $value, $fileData);
                    $this->filesystem->put($userModelFile, $fileData);
                    $this->warn($userModelFile . ' Updated with <info>' . trim($value). '</info>');
                }
            }

            $this->warn('Publishing Laravel Permissions Files');
            Artisan::call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider'], $this->getOutput());
            $this->warn('Seeding the Database. Please wait...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
            Artisan::call('optimize:clear', [], $this->getOutput());
            Artisan::call('storage:link', [], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'AdminSeeder'], $this->getOutput());
            if ($this->confirm('Do you want to Seed Flight Data?', true, true)) {
                Artisan::call('db:seed', ['--class' => 'FlightSeeder'], $this->getOutput());
            }
        }
    }

    public function installAdminLTE() {
        if ($this->confirm('Do you want to Install AdminLTE?', true, true)) {
             //Copy AdminLTE Assets
            $sourcePath = base_path('node_modules/admin-lte/dist/assets');
            $destinationPath = storage_path('app/public/assets');

            // Copy the AdminLTE assets to the public folder
            try {
                $this->copyAdminLTE($sourcePath, $destinationPath);
                $this->warn("AdminLTE assets moved successfully.");
            } catch (Exception $e) {
                $this->warn("An error occurred: " . $e->getMessage() . "\n");
            }
        }
    }

    // Function to recursively copy directories and their contents
    public function copyAdminLTE($source, $destination)
    {
        if (is_dir($source)) {
            @mkdir($destination);
            $directory = dir($source);
            while (false !== ($entry = $directory->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $this->copyAdminLTE("$source/$entry", "$destination/$entry");
            }
            $directory->close();
        } else {
            copy($source, $destination);
        }
    }
    
    public function generatePermissionFiles()
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