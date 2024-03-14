<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;

trait HandleSpatie
{
    public function defaultInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Spatie Laravel Permission?', true, true)) {

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
            <<<ROUTES
            // Admin Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Users::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/users', App\Livewire\Users::class)->name('admin.users');
                Route::get('/users/{id}', [App\Livewire\Users::class, 'details'])->name('admin.users.show');
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
            $spatieNavs =
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
            if ((version_compare(app()->version(), '10.0.0', '<='))) {
                $kernelFile = app_path('Http/Kernel.php');
                $kernelData = $this->filesystem->get($kernelFile);
                $kerneltemStub = "\t\t//Spatie Permission Traits\n\t\t'role' => \Spatie\Permission\Middleware\RoleMiddleware::class, \n\t\t'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class, \n\t\t'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,\n\t\t//End Spatie Permission Trait";
                $kernelItemHook = (version_compare(app()->version(), '10.0.0', '>=')) ? 'protected $middlewareAliases = [' : 'protected $routeMiddleware = [';

                if (!Str::contains($kernelData, $kerneltemStub)) {
                    $KernelContents = str_replace($kernelItemHook, $kernelItemHook . PHP_EOL . $kerneltemStub, $kernelData);
                    $this->filesystem->put($kernelFile, $KernelContents);
                    $this->warn('<info>' . $kernelFile . '</info> Updated');
                }
            } else {
                $appFile = base_path('bootstrap/app.php');
                $appFileData = $this->filesystem->get($appFile);
                $kerneltemStub = "\t\t//Spatie Permission Traits\n\t\t\$middleware->alias([\n\t\t\t'role' => \Spatie\Permission\Middleware\RoleMiddleware::class, \n\t\t\t'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class, \n\t\t\t'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,\n\t\t]);\n\t\t//End Spatie Permission Trait";
                $kernelItemHook = '->withMiddleware(function (Middleware $middleware) {';

                if (!Str::contains($appFileData, $kerneltemStub)) {
                    $KernelContents = str_replace($kernelItemHook, $kernelItemHook . PHP_EOL . $kerneltemStub, $appFileData);
                    $this->filesystem->put($appFile, $KernelContents);
                    $this->warn('<info>' . $appFile . '</info> Updated');
                }
            }

            // Updating User Model
            $userModelFile = app_path('Models/User.php');
            $fileData = $this->filesystem->get($userModelFile);
            $modelReplacements = [
                "class User extends Authenticatable\n{" => "\tuse HasRoles, SoftDeletes;",
                "namespace App\Models;\n" => "use Spatie\Permission\Traits\HasRoles;\nuse Illuminate\Database\Eloquent\SoftDeletes;",
                "protected \$fillable = [" => "\t\t'phone',\n\t\t'photo',\n\t\t'title',",
            ];

            foreach ($modelReplacements as $key => $value) {
                if (!Str::contains($fileData, $value)) {
                    $fileData = str_replace($key, $key . PHP_EOL . $value, $fileData);
                    $this->filesystem->put($userModelFile, $fileData);
                    $this->warn($userModelFile . ' Updated with <info>' . trim($value) . '</info>');
                }
            }
        }
    }
}