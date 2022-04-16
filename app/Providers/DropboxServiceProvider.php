<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Storage;
// use League\Flysystem\Filesystem;
// use Spatie\Dropbox\Client as DropboxClient;
// use Spatie\FlysystemDropbox\DropboxAdapter;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Storage::extend('dropbox', function ($app, $config) {
        //     $client = new DropboxClient(
        //         $config['token']
        //     );
 
        //     return new Filesystem(new DropboxAdapter($client));
        // });

        Storage::extend('dropbox', function ($app, $config) {
            $adapter = new DropboxAdapter(new DropboxClient(
                $config['token']
            ));
            $config['case_sensitive'] = false;
            return new FilesystemAdapter(
                new Filesystem($adapter, ['case_sensitive' => false]), 
                $adapter,
                $config
            );
        });
    }
}
