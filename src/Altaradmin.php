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

   public static function imagefitcrop($file, $filename, $fit_size = 200)
   {
      $file = $file;
      $filename = $filename;
      $type = str_replace('image/', '', $file['type']);
      if($type == 'jpeg'){
        $orig_image = imagecreatefromjpeg($file['tmp_name']);
      } else {
        $orig_image = imagecreatefrompng($file['tmp_name']);
      }
      list($width,$height) = getimagesize($file['tmp_name']);

      if(min($width,$height) > $fit_size){
        $scale = $fit_size/min($width,$height);
        $new_width = floor($width*$scale);
        $new_height = floor($height*$scale);
        $save_image = imagecreatetruecolor($new_width,$new_height);
        $white = imagecolorallocate($save_image,255, 255, 255);
        imagefill($save_image, 0, 0, $white);
        imagecopyresampled($save_image,$orig_image,0,0,0,0, $new_width, $new_height, $width,$height);
        $x=0;
        $y=0;
        if($new_width  > $new_height) {
            $x = floor(($new_width-$fit_size) /2);
        } else {
            $y = floor(($new_height-$fit_size) /2);
        }
        $save_image = imagecrop($save_image, ['x' => $x, 'y' => $y, 'width' => $fit_size, 'height' => $fit_size ]);
        
        if($type == 'jpeg'){
          $filename = "{$filename}.jpg";
          imagejpeg($save_image,$filename);
        } else {
          $filename = "{$filename}.png";
          imagejpeg($save_image,$filename);
        }
        imagedestroy($save_image);
        return $filename;
      } else {
        return null;
      }
   }
}
