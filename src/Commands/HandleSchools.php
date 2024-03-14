<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

trait HandleSchools
{
    public function schoolInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install School App?', true, true)) {
            $this->schoolStubDir = __DIR__ . '/../../resources/install/schoolsFiles';
            $this->generateSchoolFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
                <<<ROUTES
            // School Routes
            Route::group(['middleware' => 'auth'], function () {
                Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                
                Route::middleware(['role:admin|super-admin'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                    Route::get('/students', [App\Livewire\School\Students::class, 'home'])->name('admin.students');
                    Route::get('/attendances', App\Livewire\School\Attendances::class);
                    
                    Route::group(['prefix' => 'timetable'], function () {
                        Route::get('/', App\Livewire\School\Timetables::class)->name('admin.timetable');
                        Route::get('/schedules', App\Livewire\School\Schedules::class)->name('admin.schedules');
                    });

                    Route::group(['prefix' => 'students'], function () {
                        Route::get('/', App\Livewire\School\Students::class)->name('admin.students');
                        Route::get('/{id}', [App\Livewire\School\Students::class, 'details'])->name('admin.students.show');
                    });
                    Route::group(['prefix' => 'parents'], function () {
                        Route::get('/', App\Livewire\School\Guardians::class)->name('admin.parents');
                        Route::get('/{id}', [App\Livewire\School\Guardians::class, 'details'])->name('admin.parents.show');
                    });
                    Route::group(['prefix' => 'teachers'], function () {
                        Route::get('/', App\Livewire\School\Teachers::class)->name('admin.teachers');
                        Route::get('/{id}', [App\Livewire\School\Teachers::class, 'details'])->name('admin.teachers.show');
                    });
                    Route::group(['prefix' => 'grades'], function () {
                        Route::get('/', App\Livewire\School\Grades::class)->name('admin.grades');
                        Route::get('/{id}', [App\Livewire\School\Grades::class, 'details'])->name('admin.grades.show');
                    });
                    Route::group(['prefix' => 'notices'], function () {
                        Route::get('/', App\Livewire\School\Boards::class)->name('admin.notices');
                        Route::get('/{id}', [App\Livewire\School\Boards::class, 'details'])->name('admin.notices.show');
                    });
                });

                Route::group(['prefix' => 'teacher'], function () {
                    Route::get('/', App\Livewire\School\Teachers::class)->name('teacher');
                });

                Route::group(['prefix' => 'parent'], function () {
                    Route::get('/', App\Livewire\School\Guardians::class)->name('parent');
                });

                Route::group(['prefix' => 'student'], function () {
                    Route::get('/', App\Livewire\School\Students::class)->name('student');
                });
            });

            ROUTES;

            $fileHook = "//Route Hooks - Do not delete//";

            if (!Str::contains($updatedData, trim($spatieRoutes))) {
                $UserModelContents = str_replace($fileHook, $fileHook . PHP_EOL . $spatieRoutes, $updatedData);
                $this->filesystem->put($routeFile, $UserModelContents);
                $this->warn($routeFile . ' Updated');
            }

            // Updating User Model
            $userModelFile = app_path('Models/User.php');
            $fileData = $this->filesystem->get($userModelFile);

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

            // Find the position of the last occurrence of "}"
            $lastPosition = strrpos($fileData, $userHook);

            if (!Str::contains($fileData, $userUpdate)) {
                // Add the content after the last occurrence of "}"
                if ($lastPosition !== false) {
                    $UserModelContents = substr_replace($fileData, PHP_EOL . $userUpdate, $lastPosition, 0);
                } else {
                    // If "}" is not found, add the content at the end of the file
                    $UserModelContents = $fileData . PHP_EOL . $userUpdate;
                }

                // Write the updated content back to the file
                $this->filesystem->put($userModelFile, $UserModelContents);
                $this->warn($userModelFile . ' Updated');
            }
        }
    }

    public function generateSchoolFiles()
    {
        $files = $this->filesystem->allFiles($this->schoolStubDir, true);
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