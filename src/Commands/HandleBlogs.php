<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

trait HandleBlogs
{
    public function blogInstall()
    {
        //Spatie Laravel Permission Installation
        if ($this->confirm('Do you want to Install Blog App?', true, true)) {
            $this->blogStubDir = __DIR__ . '/../../resources/install/blogsFiles';
            $this->generateBlogFiles();

            //Updating Routes
            $routeFile = base_path('routes/web.php');
            $updatedData = $this->filesystem->get($routeFile);
            $spatieRoutes =
            <<<ROUTES
            // Admin Routes
            Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
                Route::get('/posts', App\Livewire\Posts::class)->name('admin.posts');
            });
            
            // User Routes
            Route::middleware(['web'])->prefix(config("admin.blogRoute", "blog"))->group(function () {
                Route::get('/', App\Livewire\BlogPosts::class)->name(config("admin.blogRoute", "blog"));
                Route::get('/post/{post:id}', [App\Livewire\BlogPosts::class, 'show'])->name('blog.show');
                Route::get('/category/{slug}', [App\Livewire\BlogPosts::class, 'category'])->name('blog.category');
                Route::get('/archive/{year}/{month}', [App\Livewire\BlogPosts::class, 'archive'])->name('blog.archive');
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
            public function likes() {
                return \$this->belongsToMany(Post::class, 'post_like')->withTimestamps();
            }
            
            public function hasLiked(Post \$post) {
                return \$this->likes()->where('post_id', \$post->id)->exists();
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

            Artisan::call('db:seed', ['--class' => 'BlogSeeder'], $this->getOutput());
        }
    }

    public function generateBlogFiles()
    {
        $files = $this->filesystem->allFiles($this->blogStubDir, true);
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