<?php

namespace Flightsadmin\Admin\Commands;

use Illuminate\Support\Str;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\Artisan;

trait HandleDefaultSettings
{
    public function defaultSetting()
    {
        if ($this->confirm('Do you want to scaffold Authentication files? Only skip if you have authentication system on your App', true, true)) {
            Artisan::call('ui:auth', ['--force' => true], $this->getOutput());
        }

        $this->line('');
        $deleteFiles = [
            'resources/sass',
            'resources/css',
            'resources/js',
            'public/css',
            'public/js',
            'public/build',
            'public/fonts',
        ];

        foreach ($deleteFiles as $deleteFile) {
            if ($this->filesystem->exists($deleteFile)) {
                $this->filesystem->delete($deleteFile);
                $this->filesystem->deleteDirectory($deleteFile);
                $this->warn('Deleted file: <info>' . $deleteFile . '</info>');
            }
        }

        $this->crudStubDir = __DIR__ . '/../../resources/install/permissionsFiles';
        $this->generateCrudFiles();
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
    
    public function updateComposer() {
        $composerFilePath = base_path('composer.json');
        $helperFilePath = 'app/Helpers/Settings.php';
        $composerJson = json_decode(file_get_contents($composerFilePath), true);
        if (!isset($composerJson['autoload']['files'])) {
            $composerJson['autoload']['files'] = [];
        }
        if (!in_array($helperFilePath, $composerJson['autoload']['files'])) {
            $composerJson['autoload']['files'][] = $helperFilePath;
        }
        file_put_contents($composerFilePath, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        exec('composer dump-autoload');
        $this->warn("Helper file added to autoload in composer.json.");
    }

    public function correctLayoutExtention($directory, $searchExtends, $replaceExtends) {
        $dir = new RecursiveDirectoryIterator($directory);
        $iterator = new RecursiveIteratorIterator($dir);
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $filePath = $file->getPathname();
                $content = file_get_contents($filePath);
                
                $newContent = str_replace($searchExtends, $replaceExtends, $content);
                
                if ($newContent !== $content) {
                    file_put_contents($filePath, $newContent);
                    $this->line("Replaced $searchExtends in: $filePath with $replaceExtends");
                }
            }
        }
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
}