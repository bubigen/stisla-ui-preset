<?php

namespace Bubigen\LaravelUi\Stisla;

use Laravel\Ui\AuthCommand;
use InvalidArgumentException;
use Illuminate\Console\Command;

class StislaAuth extends AuthCommand
{
    const STUBSPATH = __DIR__ . '/../stubs/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stisla:auth
                    { type=stisla : The preset type (stisla) }
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'home.stub' => 'home.blade.php',
        'profile/edit.stub' => 'profile/edit.blade.php',
        'profile/form.stub' => 'profile/form.blade.php',
        'profile/password.stub' => 'profile/password.blade.php',
        'components/alert.stub' => 'components/alert.blade.php',
        'components/toast.stub' => 'components/toast.blade.php',
        'scripts/datatables.stub' => 'scripts/datatables.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        $this->ensureDirectoriesExist();
        $this->ensureStislaDirectoriesExist();
        $this->exportViews();

        if (! $this->option('views')) {
            $this->exportBackend();
            $this->exportStislaBackend();
        }

        $this->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureStislaDirectoriesExist()
    {
        if (! is_dir($directory = $this->getViewPath('profile'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getViewPath('components'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getViewPath('scripts'))) {
            mkdir($directory, 0755, true);
        }
        
        if (! is_dir($directory = app_path('Http/Requests/Profile'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                static::STUBSPATH.'views/'.$key,
                $view
            );
        }
    }

    /**
     * Export the authentication backend.
     *
     * @return void
     */
    protected function exportStislaBackend()
    {
        file_put_contents(
            app_path('Http/Controllers/ProfileController.php'),
            $this->compileStislaControllerStub()
        );

        file_put_contents(
            app_path('Http/Requests/Profile/ChangePasswordRequest.php'),
            $this->compileStislaRequestStub()
        );

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(static::STUBSPATH.'routes.stub'),
            FILE_APPEND
        );
    }

    /**
     * Compiles the "ProfileController" stub.
     *
     * @return string
     */
    protected function compileStislaControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(static::STUBSPATH.'controllers/ProfileController.stub')
        );
    }

    /**
     * Compiles the "ChangePasswordRequest" stub.
     *
     * @return string
     */
    protected function compileStislaRequestStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(static::STUBSPATH.'requests/profile/ChangePasswordRequest.stub')
        );
    }
}
