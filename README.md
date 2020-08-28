# Altar Admin
Paket Admin Auth dan Resource. Paket yang terintegrasi dengan Altar ([https://github.com/aldhix/altar](https://github.com/aldhix/altar))
## Use
- Laravel 7 ([https://laravel.com/](https://laravel.com/))
- Bootstrap v4.4.1 ([https://getbootstrap.com/](https://getbootstrap.com/))
- AdminLTE  v3.0.5 ([https://adminlte.io/](https://adminlte.io/))
- Altar ([https://github.com/aldhix/altar](https://github.com/aldhix/altar))

## Instalasi
Pastikan Altar sudah terinstal dan sudah mengkonfigurasi koneksi database pada laravel di file `.env` dan `config/database.php` apabila tahap ini belum dilakukan jangan dulu ketahap berikutnya. 

Instal terlebih dahulu Laravel/UI :

`composer require laravel/ui`

### Call Seeder
Pada file`database\seeds\DatabaseSeeder.php` panggil seeder yand telah dibuat diatas.

    public function run()
    {
	    $this->call(AdminSeeder::class);
    }
### Middleware Authenticate & RedirectIfAuthenticated 
Ubah dibagian middleware Authenticate di file `app\Http\Middleware\Authenticate.php` pada method `redirectTo` tambahkan perintah dibagian paling atas. Ini bertujuan apabila **user belum login** ketika mengakses prefix admin akan diredirect ke `route(admin.login)`.

    protected function redirectTo($request)
    {
	    if($request->is('admin*')){
		    return route('admin.login');
	    }
	    .............
    }

Masih pada bagian middleware ubah RedirectIfAuthenticated pada file `app\Http\Middleware\RedirectIfAuthenticated.php` pada method `handle` tambahkan perintah  dibagian paling atas. Ini bertujuan apabila **user telah melakukan login** tetapi mengakses halaman `admin/login` maka akan diredirect ke `route('admin.home')`.

    public function handle($request, Closure $next, $guard = null)
    {
	    if(Auth::guard('admin')->check()){
		    return redirect()->route('admin.home');
	    }
	    ................
    }
### Routes
Lakukan penambahan route pada `routes\web.php` tambahkan perintah.

    Altaradmin::routes('admin',function(){
    	Demo::routes();
    	Route::resource('admin', 'AdminController')->middleware(['altaradmin.role:super,admin']);
    });

### Command
Pada terminal lakukan perintah dibawah ini:

    composer require aldhix/altaradmin
    php artisan vendor:publish --provider=Aldhix\Altaradmin\ServiceProvider --force
    composer dump-autoload
    php artisan migrate
    php artisan db:seed

## Fitur

### Altaradmin Class

Pengaturan role pada blade dengan perintah `Altaradmin::role('level_1',level_2','level_n')`, contoh menggunakan role di view:

Contoh satu role :

    @if( Altaradmin::role('admin') )
    ................
    @endif
  
Contoh lebih dari satu role: 

    @if( Altaradmin::role('admin','editor') )
    ................
    @endif

Daftar Route yang terdapat pada `Altaradmin::routes(prefix, callback)` pada route Altaradmin ini sudah menggunakan middleware` auth:admin`:

| Method | Route Name | 
|--|--|
| GET/POST | admin.login |
| POST | admin.logout |
| GET | admin.home |
| GET/PUT | admin.profile |

Route resource admin gunakan perintahnya `Route::resource('admin','AdminController')`

### Middleware AltaradminRole
Memberi batasan akses dapat menggunakan middleware `altaradmin.role:role_1, role_2, role_n`, contoh role diakses oleh super dan admin:

    Route::resource('admin', 'AdminController')->middleware(['altaradmin.role:super,admin']);

### Logout
Membuat logout gunakan form yang disembuyikan dengan method post contoh menggunakan link:

    <a href="{{route('admin.logout')}}" 
	    onclick="event.preventDefault(); document.getElementById('logout-page').submit();" 
	    class="dropdown-item"> Logout
	    <form id="logout-page" action="{{ route('admin.logout') }}" method="post" style="display: none;">@csrf</form>
    </a>
