<?php

namespace Arje\SmsOffice\Providers;

use Illuminate\Support\ServiceProvider;


class SmsOfficeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'../../../../config/arje_sms_office.php' => config_path('arje_sms_office.php')
        ],'config');
    }
}
