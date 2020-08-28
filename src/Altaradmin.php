<?php

namespace Aldhix\Altaradmin;
use Route;
use Auth;

class Altaradmin
{
   public static function routes($prefix, $callback = null )
   {
    
      Route::group([
            'prefix'=>$prefix,
            'middleware'=>['auth:admin'],
        ], function() {
            Route::get('/','AdminHomeController@index')->name('admin.home');
            Route::get('admin/profile','AdminController@profile')->name('admin.profile');
            Route::put('admin/profile','AdminController@updateProfile');
       });

      Route::group([
        'prefix' => $prefix,
        'namespace'=>'Admin\Auth',
        ], function() {
          Route::get('login','AdminLoginController@showLoginForm')->name('admin.login');
          Route::post('login','AdminLoginController@login');
          Route::post('logout','AdminLoginController@logout')->name('admin.logout');
      });

      if(is_callable( $callback )){
          Route::group([
            'prefix'=>$prefix,
            'middleware'=>['auth:admin'],
          ], $callback );
      }

   }

   public static function role(...$roles)
   {
    
    $check = Auth::guard('admin')->check();
    $level = Auth::guard('admin')->user()->role;

    if($check && in_array($level, $roles)) {
          return true;   
      } else {
         return false;
      }
   }

   public static function user()
   {
      return Auth::guard('admin')->user();
   }

   public static function id()
   {
      return Auth::guard('admin')->id();
   }

}
