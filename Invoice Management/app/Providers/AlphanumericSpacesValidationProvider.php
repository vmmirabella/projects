<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AlphanumericSpacesValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		//https://gist.github.com/elena-kolevska/8580401#gistcomment-1725382
        Validator::extend('alpha_num_spaces', 
		function($attribute, $value) { 
			return preg_match('/^[a-z\d\s]+$/i', $value); 
		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
