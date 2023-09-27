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
                Route::view('schedules', 'livewire.schedules.index')->name('admin.schedules');
                Route::view('delays', 'livewire.delays.index')->name('admin.delays');
                Route::view('services', 'livewire.services.index')->name('admin.services');
                Route::view('permissions', 'livewire.permissions.index')->name('admin.permissions');
                Route::view('roles', 'livewire.roles.index')->name('admin.roles');
                Route::view('posts', 'livewire.posts.index')->name('admin.posts');
                Route::view('flights', 'livewire.flights.index')->name('admin.flights');
                Route::view('airlines', 'livewire.airlines.index')->name('admin.airlines');
                Route::view('registrations', 'livewire.registrations.index')->name('admin.registrations');
                Route::view('users', 'livewire.users.index')->name('admin.users');
            });
            
            // User Routes
            Route::middleware(['web', 'role:guest|super-admin|admin|user'])->prefix(config("admin.blogRoute", "blog"))->group(function () {
                Route::get('/', App\Livewire\BlogPosts::class)->name('blog');
                Route::get('/{post:id}', [App\Livewire\BlogPosts::class, 'show'])->name('blog.show');
                Route::get('/category/{slug}', [App\Livewire\BlogPosts::class, 'category'])->name('blog.category');
                Route::get('/archive/{year}/{month}', [App\Livewire\BlogPosts::class, 'archive'])->name('blog.archive');
            });

            // Social Login Routes
            Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirect']);
            Route::get('/auth/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'callback']);
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
            $spatieNavs  =
            <<<NAV
                                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('blog') }}">Blog</a>
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
            // Update Relationship
            $userUpdate = 
            <<<NAV
            public function likes() {
                return \$this->belongsToMany(Post::class, \'post_like\')->withTimestamps();
            }

            public function hasLiked(Post $post) {
                return \$this->likes()->where(\'post_id\', \$post->id)->exists();
            }
            NAV;

            $userHook = "}";

            // Find the position of the last occurrence of "];"
            $lastPosition = strrpos($fileData, $userHook);

            if (!Str::contains($fileData, $userUpdate)) {
                // Add the content after the last occurrence of "];"
                if ($lastPosition !== false) {
                    $UserModelContents = substr_replace($fileData, PHP_EOL . $userUpdate, $lastPosition, 0);
                } else {
                    // If "];" is not found, add the content at the end of the file
                    $UserModelContents = $fileData . PHP_EOL . $userUpdate;
                }

                // Write the updated content back to the file
                $this->filesystem->put($userModelFile, $UserModelContents);
                $this->warn($userModelFile . ' Updated');
            }

            $this->line('');
            $this->warn('Publishing Laravel Permissions Files');
            Artisan::call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider'], $this->getOutput());
            $this->warn('Seeding the Database. Please wait...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
            Artisan::call('optimize:clear', [], $this->getOutput());
            Artisan::call('storage:link', [], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'AdminDatabaseSeeder'], $this->getOutput());
            if ($this->confirm('Do you want to Seed Testing Data?', true, true)) {
                Artisan::call('db:seed', ['--class' => 'FlightsDatabaseSeeder'], $this->getOutput());
            }
        }
    }

    public function socialLoginInstall() {
        if ($this->confirm('Do you want to Enable Social Login?', true, true)) {
            // Update ENV File
            $envFile = base_path('.env');
            $socialID = "GOOGLE_CLIENT_ID=969178219302-a013oqprusp6hki4gjsu978uae0fine6.apps.googleusercontent.com\nGOOGLE_CLIENT_SECRET=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";
            $envData = file_get_contents($envFile);
            if (!str_contains($envData, $socialID)) {
                file_put_contents($envFile, "\n$socialID", FILE_APPEND);
            }
            $this->warn($envFile. " Update\n");
            //Update Services File
            $servicesFile = base_path('config/services.php');
            $servicesData = $this->filesystem->get($servicesFile);
            $servicesUpdate = 
            <<<SERVICE
                'google' => [
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect' => '/auth/google/callback',
                ],
            SERVICE;
            $serviceFileHook = "return [\n";

            if (!Str::contains($servicesData, $servicesUpdate)) {
                $UserModelContents = str_replace($serviceFileHook, $serviceFileHook . PHP_EOL . $servicesUpdate, $servicesData);
                $this->filesystem->put($servicesFile, $UserModelContents);
                $this->warn($servicesFile . ' Updated');
            }

            //Copy AdminLTE Assets
            $sourcePath = base_path('node_modules/admin-lte/dist/assets');
            $destinationPath = storage_path('app/public/assets');

            // Copy the AdminLTE assets to the public folder
            try {
                $this->copyAdminLTE($sourcePath, $destinationPath);
                $this->warn("AdminLTE assets moved successfully.\n");
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