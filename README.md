# AdminLTE dengan Laravel 7
Admin LTE dengan Component Laravel 7

## Instalasi
Instal adminlte dengan composer :

`composer require aldhix/altar`

Publish provider pada laravel :

`php artisan vendor:publish --provider=Aldhix\Altar\ServiceProvider`

Untuk mengujinya pada route tambahkan route demo `Demo::routes()`, buat server laravel ( `php artisan serv` ), kemudian ketikan pada browser http://localhost:8000/demo 

