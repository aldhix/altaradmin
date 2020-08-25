# Altar Admin
Paket Admin Auth dan Resource. Paket yang terintegrasi dengan Altar ([https://github.com/aldhix/altar](https://github.com/aldhix/altar))

## Instalasi
Pastikan Altar sudah terinstal dan sudah mengkonfigurasi database di file `.env` dan `config/database.php` apabila tahap ini belum dilakukan jangan dulu ketahap berikutnya. 

Instal terlebih dahulu Laravel/UI, apabila sudah menginstallnya silahkan lewati langkah ini. 
`composer require laravel/ui`

Instal Adminaltar dengan composer.
`composer require aldhix/altaradmin`

Publish Provider Service .
`php artisan vendor:publish --provider=Aldhix\Altaradmin\ServiceProvider`

Untuk menghindari kesalahan pada saat migrate, pada file `app\Providers\AppServiceProvider.php` tambahkan `defaultStringLength` menjadi 191.

    use Illuminate\Support\Facades\Schema;
    ..................
    public function boot()
    {
    	Schema::defaultStringLength(191);
    }

Buat Admin Seeder.
`php artisan make:seeder UserSeeder`

Setelah `AdminSeeder` dibuat tambahkan perintah untuk membuat record admin dengan seeder.

    use Illuminate\Support\Str;
    use Aldhix\Altaradmin\Models\Admin;
    ....................................
    public function run()
    {
	    Admin::create([
		    'name'=>'Administrator',
		    'email'=>'admin@localhost.com',
		    'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		    'level'=>'super',
		    'remember_token' => Str::random(10),
	    ]);
	    $admin = factory(Admin::class, 2)->create();
    }


Pada file`database\seeds\DatabaseSeeder.php` panggil seeder yand telah dibuat diatas.

    public function run()
    {
	    $this->call(AdminSeeder::class);
    }

Lakukan perintah migrate dan seed.

    php artisan migrate
    php artisan db:seed

Konfigurasi auth di file `config\auth.php` tambahkan perintah pada bagian guards, providers, dan passwords.

    'guards' => [
	    ............
	    'admin' => [
		    'driver' => 'session',
		    'provider' => 'admins',
	    ]
    ],
    
    'providers' => [
	    ...........
	    'admins' => [
		    'driver' => 'eloquent',
		    'model' => Aldhix\Altaradmin\Models\Admin::class,
	    ],
    ],
    
    'passwords' => [
	    ...........
	    'admins' => [
		    'provider' => 'admins',
		    'table' => 'password_resets',
		    'expire' => 60,
	    ],
    ],


Ubah dibagian middleware Authenticate di file `app\Http\Middleware\Authenticate.php` pada method `redirectTo` tambahkan perintah dibagian paling atas. Ini bertujuan apabila user belum login ketika mengakses prefix admin akan diredirect ke `route(admin.login)`.

    protected function redirectTo($request)
    {
	    if($request->is('admin*')){
		    return route('admin.login');
	    }
	    .............
    }



Masih pada bagian middleware ubah RedirectIfAuthenticated pada file `app\Http\Middleware\RedirectIfAuthenticated.php` pada method `handle` tambahkan perintah  dibagian paling atas. Ini bertujuan apabila user melakukan login tetapi mengakses halaman `admin/login` maka akan diredirect ke `route('admin.home')`.

    public function handle($request, Closure $next, $guard = null)
    {
	    if(Auth::guard('admin')->check()){
		    return redirect()->route('admin.home');
	    }
	    ................
    }

Registrasi Middleware check level admin pada `kernel` di file `app\Http\Kernel.php` tambahkan dibagian `$routeMiddleware`.

    protected $routeMiddleware = [
	    ......................
	    'level' => \Aldhix\Altaradmin\Middleware\CheckAdminLevel::class,
    ];


Pada `routes\web.php` tambahkan perintah. Langkah ini untuk memanggil route admin. Bertujuan untuk mengujicoba

    Route::group([
		'prefix'=>'admin',
		'middleware'=>['auth:admin','level:super'],
	], function() {
	    Demo::routes();
    });
    
    Altaradmin::resource('admin');
    Altaradmin::routes('admin');


Membuat logout bisa menggunakan link contoh sebagai berikut:

    <a href="{{route('admin.logout')}}" 
	    onclick="event.preventDefault(); document.getElementById('logout-page').submit();" 
	    class="dropdown-item"> Logout
	    <form id="logout-page" action="{{ route('admin.logout') }}" method="post" style="display: none;">@csrf</form>
    </a>
