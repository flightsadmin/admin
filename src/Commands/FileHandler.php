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
            // Admin Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Products::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/users', App\Livewire\Users::class)->name('admin.users');
                Route::get('/roles', App\Livewire\Roles::class)->name('admin.roles');
                Route::get('/permissions', App\Livewire\Permissions::class)->name('admin.permissions');
                Route::get('/settings', App\Livewire\Settings::class)->name('admin.settings');
            });
            
            // Shop Routes
            Route::middleware(['web'])->prefix(config("admin.shopRoute", "shop"))->group(function () {    
                Route::get('/', [App\Livewire\Products::class, 'renderUser'])->name(config("admin.shopRoute", "shop"));
                Route::get('/{product:id}', [App\Livewire\Products::class, 'show'])->name('shop.show');
                Route::get('/category/{slug}', [App\Livewire\Products::class, 'category'])->name('shop.category');
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
                                    @role('super-admin|admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route(config('admin.adminRoute')) }}">{{ ucwords(config('admin.adminRoute'))}}</a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route(config('admin.shopRoute')) }}">{{ ucwords(config('admin.shopRoute'))}}</a>
                                    </li>
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
                    return \$this->belongsToMany(Product::class, 'product_like')->withTimestamps();
                }
                
                public function hasLiked(Product $product) {
                    return \$this->likes()->where('product_id', \$product->id)->exists();
                }
                
                public function cartItems() {
                    return \$this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withTimestamps();
                }
                
                public function hasAdded(Product $product) {
                    return \$this->cartItems()->where('product_id', \$product->id)->exists();
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

            $this->warn('Publishing Laravel Permissions Files');
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

    public function socialLoginInstall() {
        if ($this->confirm('Do you want to Use AdminLTE v4?', true, true)) {
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