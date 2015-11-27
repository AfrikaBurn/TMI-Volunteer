<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('hashed', function($attribute, $value, $parameters)
        {
            $user = User::where('name', Input::get('name'))->get();

            if($user->count())
            {
                $user = $user[0];
                
                if(Hash::check($value, $user->password))
                {
                    return true;
                }
            }
            
            return false;
        });

        Validator::extend('time', function($attribute, $value, $parameters)
        {
            $value = trim($value);
            
            // Check against 12 hour time (with AM/PM) or 24 hour time
            $twelve = date_parse_from_format('h:i a', $value);
            $twentyfour = date_parse_from_format('H:i', $value);

            if($twelve['error_count'] === 0 || $twentyfour['error_count'] === 0)
            {
                return true;
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
