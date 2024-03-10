<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Install extends Command
{
    use HandleSpatie, HandleSchedule, HandleDefaultSettings;
	protected $filesystem;
    protected $crudStubDir;
    protected $permStubDir;
    private $replaces = [];
	
    protected $signature = 'admin:install';
    protected $description = 'Install Schedule Admin App';

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
            $this->spatiePermissionsInstall();
            $this->scheduleInstall();
            $this->updateComposer();
            // Update Auth Routes
            $authRoutes = "\nAuth::routes(['register' => false]);\nRoute::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');";
            $content = file_get_contents($routeFile);
            $content = str_replace("Auth::routes();\n\nRoute::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');", '', $content);
            if (strpos($content, $authRoutes) === false) {
                $content .= $authRoutes;
            }
            file_put_contents($routeFile, trim($content));            

		$this->line('');
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

        $viewsDirectory = resource_path('views'); // Adjust this path if needed
        $searchExtends = "@extends('layouts.app')";
        $replaceExtends = "@extends('components.layouts.app')";
        $this->correctLayoutExtention($viewsDirectory, $searchExtends, $replaceExtends);
        $this->line('');
        
        $this->warn('All set, Your Schedulling app is ready for take off');		
	  }
		else $this->warn('Installation Aborted, No file was changed');
    }
	
	public function generateCrudFiles()
    {
        $files = $this->filesystem->allFiles($this->crudStubDir, true);
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

    private function replace($content)
    {
        foreach ($this->replaces as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        return $content;
    }
}