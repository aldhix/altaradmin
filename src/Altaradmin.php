<?php

namespace Aldhix\Altaradmin;
use Route;
use Auth;

class Altaradmin
{
 
   public static function resource($prefix = 'admin',$middleware=['auth:admin'])
   {
       Route::group([
            'prefix'=>$prefix,
            'middleware'=>$middleware,
            'namespace'=>'\Aldhix\\Altaradmin\\Controllers',
        ], function() {
            Route::resource('admin','AdminController');
        });
       Route::get($prefix,'HomeAdminController@index')->name('admin.home')->middleware('auth:admin');
   }

   public static function routes($prefix = 'admin')
   {
        Route::group([
            'prefix'=>$prefix,
            'namespace'=>'\Aldhix\\Altaradmin\\Controllers\\Auth',
        ], function() {
            Route::get('login','AdminLoginController@loginForm')->name('admin.login');
            Route::post('login','AdminLoginController@login');
            Route::post('logout','AdminLoginController@logout')->name('admin.logout');
        });
   }

   public static function level($level = null)
   {
     return (Auth::guard('admin')->check() && Auth::guard('admin')->user()->level == $level) ;
   }
}
