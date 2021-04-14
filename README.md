1) Rename .env.example to .env
2) Create database table with a name "eshopdb" in phpmyadmin
3) Open CMD on project directory
4) composer install
5) php artisan migrate
6) npm install && npm run dev
7) php artisan key:generate
8) go to vendor/laravel/fortify/src/Actions/AttemptToAuthenticate.php file, press enter after 56th line and add the following code : 
   if (Auth::user()->utype === 'ADM') {
   session(['utype' => 'ADM']);
   return redirect(RouteServiceProvider::HOME);
   } else if (Auth::user()->utype === 'USR') {
   session(['utype' => 'USR']);
   return redirect(RouteServiceProvider::HOME);
   }
   I know this is a bad practice to handle multi-authentication, but for now it's a way to make it work, will solve this in a proper way
9) php artisan serve
