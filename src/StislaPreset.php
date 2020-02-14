<?php

namespace Bubigen\LaravelUi\Stisla;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\Presets\Preset;

class StislaPreset extends Preset
{
    const STUBSPATH = __DIR__ . '/../stubs/';

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::ensureDirectoriesExist();
        static::updatePackages();
        static::updateAssets();
        static::updateWebpackConfiguration();
        
        //static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            '@fortawesome/fontawesome-free' => '^5.10.2',
            'popper.js' => '^1.14',
            'moment' => '^2.24',
            'bootstrap' => '^4.3.1',
            'jquery' => '^3.4',
            'jquery.nicescroll' => '^3.7'
        ] + Arr::except($packages, ['vue', 'vue-template-compiler']);
    }

    /**
     * Update the assets.
     *
     * @return void
     */
    protected static function updateAssets()
    {
        $filesystem = new Filesystem;

        $filesystem->copyDirectory(static::STUBSPATH.'/js', resource_path('js'));
        $filesystem->copyDirectory(static::STUBSPATH.'/sass', resource_path('sass'));
        $filesystem->copyDirectory(static::STUBSPATH.'/assets', resource_path('assets'));
        $filesystem->copyDirectory(static::STUBSPATH.'views/layouts', resource_path('views/layouts'));
    }

    /**
     * Setup Auth.
     *
     * @return void
     */
    public static function setupAuth()
    {
        $filesystem = new Filesystem;

        $filesystem->copyDirectory(static::STUBSPATH.'/views/auth', resource_path('views/layouts'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(static::STUBSPATH.'/js/app.js', resource_path('js/app.js'));
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(static::STUBSPATH.'/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected static function ensureDirectoriesExist()
    {
        if (! is_dir($directory = static::getViewPath('layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = static::getViewPath('auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected static function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

}
