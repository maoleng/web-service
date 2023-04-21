<?php

namespace Libraries;

class AppLoader
{
    public static function load(): void
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $loader = new self;
        $loader->loadAutoLoad();
        $loader->loadDatabaseDriver(env('DATABASE_DRIVER'));
        $loader->loadRequest();
        $loader->loadModels();
        $loader->loadHttp();
        $loader->loadMails();
        $loader->loadSession();
        $loader->loadRedirectResponse();
        $loader->loadSupport();
        $loader->loadExternalHelpers();
    }

    private function loadExternalHelpers(): void
    {
        require_once asset('App/Helper.php');
        $this->loadFiles('App/Helpers');
    }

    private function loadSupport(): void
    {
        $this->loadFiles('Libraries/Support');
    }

    private function loadRedirectResponse(): void
    {
        $this->loadFiles('Libraries/Response/HttpResponse');
        require_once asset('Libraries/Response/Response.php');
        $this->loadFiles('Libraries/Redirect');
    }

    private function loadSession(): void
    {
        require_once asset('Libraries/Session/Session.php');
    }

    private function loadMails(): void
    {
        require_once asset('Libraries/Mail/Mailable.php');
        $this->loadFiles('App/Mails');
    }

    private function loadHttp(): void
    {
        require_once asset('App/Http/Controllers/Controller.php');
        require_once asset('App/Http/Middlewares/Middleware.php');
    }

    private function loadModels(): void
    {
        require_once asset('Libraries/database_drivers/Model.php');
        $this->loadFiles('App/Models');
    }

    private function loadRequest(): void
    {
        $this->loadFiles('Libraries/Request');
        require_once asset('Libraries/Request/Form/FormRequest.php');
    }

    private function loadDatabaseDriver($driver): void
    {
        require_once asset('Libraries/database_drivers/'.$driver.'/Builder.php');
        require_once asset('Libraries/database_drivers/BaseBuilder.php');
        require_once asset('Libraries/database_drivers/'.$driver.'/Query.php');
        require_once asset('Libraries/database_drivers/'.$driver.'/DB.php');
    }

    private function loadAutoLoad(): void
    {
        $path = asset('vendor/autoload.php');
        if (file_exists($path)) {
            require_once $path;
        }
    }

    private function loadFiles($folder): void
    {
        $path = asset($folder);
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                $file_path = asset($folder.'/'.$file);
                if (is_file($file_path)) {
                    require_once $file_path;
                }
            }
        }
    }
}