<?php

namespace App\Providers;

use App\Rules\SecureFileUpload;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class SecureFileUploadProvider extends ServiceProvider
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
        $this->app['validator']
            ->resolver(function ($translator, $data, $rules, $messages, $customAttributes = []) {
                return new SecureFileUpload(
                    $translator,
                    $data,
                    $rules,
                    $messages,
                    $customAttributes
                );
            });
        $translation = $this->app['translator']->get('validation');
        Validator::extend(
            'secure-file',
            SecureFileUpload::class . '@validateSecureFile',
            $translation['clamav'] ?? []
        );
    }
}
