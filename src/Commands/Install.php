<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    use HandleSpatie, HandleRoster, HandleDefaultSettings, HandleFlights, HandleShops, HandleBlogs, HandleSchools;
    protected $filesystem;
    private $replaces = [];

    protected $signature = 'admin:install';
    protected $description = 'Install Admin App';

    public function handle()
    {
        $this->filesystem = new Filesystem;
        (new Filesystem)->ensureDirectoryExists(app_path('Livewire'));
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->ensureDirectoryExists(app_path('Models'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/livewire'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components/layouts'));

        if ($this->confirm('This will delete compiled assets in public folder. It will Re-Compile this. Do you want to proceed?', true, true)) {
            $routeFile = base_path('routes/web.php');
            $routeData = file_get_contents($routeFile);
            if (!str_contains($routeData, '//Route Hooks - Do not delete//')) {
                file_put_contents($routeFile, "\n//Route Hooks - Do not delete//", FILE_APPEND);
            }

            $this->defaultSetting();
            $this->defaultInstall();
            $this->rosterInstall();
            $this->flightInstall();
            $this->updateComposer();
            $this->shopInstall();
            $this->blogInstall();
            $this->schoolInstall();
            $this->socialLoginInstall();

            // Update Auth Routes
            $authRoutes = "\nAuth::routes(['register' => false]);\nRoute::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');";
            $content = file_get_contents($routeFile);
            $content = str_replace("Auth::routes();\n\nRoute::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');", '', $content);
            if (strpos($content, $authRoutes) === false) {
                $content .= $authRoutes;
            }
            file_put_contents($routeFile, trim($content));

            $this->warn('Publishing Files');
            Artisan::call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider'], $this->getOutput());
            $this->warn('Seeding the Database. Please wait...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
            Artisan::call('optimize:clear', [], $this->getOutput());
            Artisan::call('storage:link', [], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'AdminSeeder'], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'FlightSeeder'], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'RosterSeeder'], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'ShopSeeder'], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'BlogSeeder'], $this->getOutput());
            Artisan::call('db:seed', ['--class' => 'SchoolSeeder'], $this->getOutput());

            $this->warn('Running: <info>npm install</info> Please wait...');
            exec('npm install');

            //Install Social Login
            $this->installAdminLTE();

            $this->warn('Running: <info>npm run build</info> Please wait...');
            $this->line('');
            exec('npm run build');

            $this->info('Installation Complete, few seconds please, let us optimize your site');
            $this->warn('Removing Dumped node_modules files. Please wait...');

            tap(new Filesystem, function ($npm) {
                $npm->deleteDirectory(base_path('node_modules'));
                $npm->deleteDirectory(base_path('resources/views/layouts'));
                $npm->delete(base_path('yarn.lock'));
                $npm->delete(base_path('webpack.mix.js'));
                $npm->delete(base_path('package-lock.json'));
            });
            $this->line('');

            $viewsDirectory = resource_path('views');
            $searchExtends = "@extends('layouts.app')";
            $replaceExtends = "@extends('components.layouts.app')";
            $this->correctLayoutExtention($viewsDirectory, $searchExtends, $replaceExtends);
            $this->line('');

            $this->warn('All set, Your Schedulling app is ready for take off');
        } else {
            $this->warn('Installation Aborted, No file was changed');
        }
    }

    private function replace($content)
    {
        foreach ($this->replaces as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        return $content;
    }
}