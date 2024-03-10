<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;

trait HandleShops
{
    public function shopInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Shop App?', true, true)) {
            $this->shopStubDir = __DIR__ . '/../../resources/install/shopsFiles';
            $this->generateShopFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
            <<<ROUTES
            // Shop Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/', App\Livewire\Products::class)->name(config("admin.adminRoute", "admin"));
            });
            Route::middleware(['web'])->prefix(config("admin.shopRoute", "shop"))->group(function () {
                Route::get('/', App\Livewire\Products::class)->name(config("admin.adminRoute", "admin"));
                Route::get('/', [App\Livewire\Products::class, 'renderUser'])->name(config("admin.shopRoute", "shop"));
                Route::get('/checkout', [App\Livewire\Products::class, 'checkout'])->name("shop.checkout");
                Route::get('/product/{product:id}', [App\Livewire\Products::class, 'show'])->name('shop.show');
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

            // Updating User Model
            $userModelFile = app_path('Models/User.php');
            $fileData = $this->filesystem->get($userModelFile);

            $userUpdate = 
            <<<NAV
                public function likes() {
                    return \$this->belongsToMany(Product::class, 'product_like')->withTimestamps();
                }
                
                public function hasLiked(Product \$product) {
                    return \$this->likes()->where('product_id', \$product->id)->exists();
                }
                
                public function cartItems() {
                    return \$this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withTimestamps();
                }
                
                public function hasAdded(Product \$product) {
                    return \$this->cartItems()->where('product_id', \$product->id)->exists();
                }
                
                public function coupons()
                {
                    return \$this->belongsToMany(Coupon::class, 'coupon_user')->withPivot('used_at')->withTimestamps();
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

    public function socialLoginInstall() {
        if ($this->confirm('Do you want to Enable Social Login?', true, true)) {
            // Update ENV File
            $envFile = base_path('.env');
            $socialID = "GOOGLE_CLIENT_ID=969178219302-a013oqprusp6hki4gjsu978uae0fine6.apps.googleusercontent.com\nGOOGLE_CLIENT_SECRET=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";
            $envData = file_get_contents($envFile);
            if (!str_contains($envData, $socialID)) {
                file_put_contents($envFile, "\n$socialID", FILE_APPEND);
                $this->warn($envFile. " Updated");
            }
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
            
            $serviceFileHook = "];";

            // Find the position of the last occurrence of "];"
            $lastPosition = strrpos($servicesData, $serviceFileHook);
            if (!Str::contains($servicesData, $servicesUpdate)) {
                if ($lastPosition !== false) {
                    $UserModelContents = substr_replace($servicesData, PHP_EOL . $servicesUpdate, $lastPosition, 0);
                } else {
                    $UserModelContents = $servicesData . PHP_EOL . $servicesUpdate;
                }

                $this->filesystem->put($servicesFile, $UserModelContents);
                $this->warn($servicesFile . ' Updated');
            }
        }
    }

    public function generateShopFiles()
    {
        $files = $this->filesystem->allFiles($this->shopStubDir, true);
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