<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

trait FileHandler
{
    public function SchoolInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install School Module?', true, true)) {
            $this->permStubDir = __DIR__ . '/../../resources/install/permissions';
            $this->generateSchoolFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
                <<<ROUTES
            Route::group(['middleware' => 'auth'], function () {
                Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
            
                Route::middleware(['role:admin|super-admin'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                    Route::get('/', [App\Livewire\Students::class, 'home'])->name('admin');
                    Route::get('/attendances', App\Livewire\Attendances::class);
                    Route::get('/settings', App\Livewire\Settings::class)->name('admin.settings');
                    Route::get('/roles', App\Livewire\Roles::class)->name('admin.roles');
                    Route::get('/permissions', App\Livewire\Permissions::class)->name('admin.permissions');
            
                    Route::group(['prefix' => 'users'], function () {
                        Route::get('/', App\Livewire\Users::class)->name('admin.users');
                        Route::get('/{id}', [App\Livewire\Users::class, 'details'])->name('admin.users.show');
                    });
                    Route::group(['prefix' => 'students'], function () {
                        Route::get('/', App\Livewire\Students::class)->name('admin.students');
                        Route::get('/{id}', [App\Livewire\Students::class, 'details'])->name('admin.students.show');
                    });
                    Route::group(['prefix' => 'parents'], function () {
                        Route::get('/', App\Livewire\Guardians::class)->name('admin.parents');
                        Route::get('/{id}', [App\Livewire\Guardians::class, 'details'])->name('admin.parents.show');
                    });
                    Route::group(['prefix' => 'teachers'], function () {
                        Route::get('/', App\Livewire\Teachers::class)->name('admin.teachers');
                        Route::get('/{id}', [App\Livewire\Teachers::class, 'details'])->name('admin.teachers.show');
                    });
                    Route::group(['prefix' => 'grades'], function () {
                        Route::get('/', App\Livewire\Grades::class)->name('admin.grades');
                        Route::get('/{id}', [App\Livewire\Grades::class, 'details'])->name('admin.grades.show');
                    });
                    Route::group(['prefix' => 'notices'], function () {
                        Route::get('/', App\Livewire\Boards::class)->name('admin.notices');
                        Route::get('/{id}', [App\Livewire\Boards::class, 'details'])->name('admin.notices.show');
                    });
                });
            
                Route::group(['prefix' => 'teacher'], function () {
                    Route::get('/', App\Livewire\Teachers::class)->name('teacher');
                });
            
                Route::group(['prefix' => 'parent'], function () {
                    Route::get('/', App\Livewire\Guardians::class)->name('parent');
                });

                Route::group(['prefix' => 'student'], function () {
                    Route::get('/', App\Livewire\Students::class)->name('student');
                });
            });
            ROUTES;

            $fileHook = "//Route Hooks - Do not delete//";

            if (!Str::contains($updatedData, trim($spatieRoutes))) {
                $UserModelContents = str_replace($fileHook, $fileHook . PHP_EOL . $spatieRoutes, $updatedData);
                $this->filesystem->put($routeFile, $UserModelContents);
                $this->warn($routeFile . ' Updated');
            }

            //Updating NavBar
            $layoutsFile = base_path('resources/views/components/layouts/app.blade.php');
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
                "class User extends Authenticatable\n{" => "\tuse HasRoles;",
                "namespace App\Models;\n" => "use Spatie\Permission\Traits\HasRoles;",
                "protected \$fillable = [" => "\t\t'username',\t\t'phone',\n\t\t'photo',\n\t\t'title',",
            ];

            foreach ($modelReplacements as $key => $value) {
                if (!Str::contains($fileData, $value)) {
                    $fileData = str_replace($key, $key . PHP_EOL . $value, $fileData);
                    $this->filesystem->put($userModelFile, $fileData);
                    $this->warn($userModelFile . ' Updated with <info>' . trim($value) . '</info>');
                }
            }

            // Update Relationship
            $userUpdate =
                <<<NAV
                            public function teacher()
                            {
                                return \$this->hasOne(Teacher::class);
                            }
                        
                            public function student()
                            {
                                return \$this->hasOne(Student::class);
                            }
                        
                            public function parent()
                            {
                                return \$this->hasOne(Guardian::class);
                            }
                        
                        NAV;

            $userHook = "}";
            
            $lastPosition = strrpos($fileData, $userHook);

            if (!Str::contains($fileData, $userUpdate)) {
                if ($lastPosition !== false) {
                    $UserModelContents = substr_replace($fileData, PHP_EOL . $userUpdate, $lastPosition, 0);
                } else {
                    $UserModelContents = $fileData . PHP_EOL . $userUpdate;
                }
                $this->filesystem->put($userModelFile, $UserModelContents);
                $this->warn($userModelFile . ' Updated');
            }

            // Updating Login Controller
            $loginControllerFile = app_path('Http\Controllers\Auth\LoginController.php');
            $loginData = $this->filesystem->get($loginControllerFile);
            $loginUpdate =
                <<<NAV
                            protected function username()
                            {
                                \$loginValue = request()->input('login');
                                \$field = filter_var(\$loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
                                request()->merge([\$field => \$loginValue]);
                                return \$field;
                            }

                        NAV;

            $loginHook = "}";
            
            $lastPosition = strrpos($loginData, $loginHook);

            if (!Str::contains($loginData, $loginUpdate)) {
                if ($lastPosition !== false) {
                    $LoginContents = substr_replace($loginData, PHP_EOL . $loginUpdate, $lastPosition, 0);
                } else {
                    $LoginContents = $loginData . PHP_EOL . $loginUpdate;
                }
                $this->filesystem->put($loginControllerFile, $LoginContents);
                $this->warn($loginControllerFile . ' Updated');
            }

            $this->warn('Publishing School Management Files');
            Artisan::call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider'], $this->getOutput());
            $this->warn('Seeding the Database. Please wait...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
            Artisan::call('optimize:clear', [], $this->getOutput());
            Artisan::call('storage:link', [], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'AdminSeeder'], $this->getOutput());
            if ($this->confirm('Do you want to Seed School Data?', true, true)) {
                Artisan::call('db:seed', ['--class' => 'SchoolSeeder'], $this->getOutput());
            }
        }
    }

    public function socialLoginInstall()
    {
        if ($this->confirm('Do you want to Use AdminLTE v4?', true, true)) {
            //Copy AdminLTE Assets
            $sourcePath = base_path('node_modules/admin-lte/dist/assets');
            $destinationPath = storage_path('app/public/assets');

            try {
                $this->copyAdminLTE($sourcePath, $destinationPath);
                $this->warn("AdminLTE assets moved successfully.");
            } catch (Exception $e) {
                $this->warn("An error occurred: " . $e->getMessage() . "\n");
            }
        }
    }

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

    public function generateSchoolFiles()
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