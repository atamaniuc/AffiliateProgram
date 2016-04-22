# Test Laravel Project

==============================================================
BACKEND
==============================================================
https://github.com/barryvdh/laravel-ide-helper
install XAMPP + php-extensions on Windows
install laravel

php artisan migrate
php artisan make:auth
php artisan make:seeder UsersTableSeeder
php artisan db:seed --class=UsersTableSeeder

php artisan make:migration add_amount_to_users_table --table=users
php artisan make:migration create_referrals_table --table=referrals

php artisan make:controller ReferralsController
php artisan make:model Referrals



https://github.com/appzcoder/crud-generator
php artisan crud:controller UsersController --crud-name=users --model-name=User --view-path="users" --route-group=admin
php artisan crud:controller UsersController --crud-name=users --model-name=User --route-group=admin
php artisan crud:view users --fields="name:string, email:string, amount:float" --route-group=admin

==============================================================







==============================================================
FRONTEND
==============================================================
npm install -g yo gulp bower
npm install -g generator-gulp-angular
mkdir frontend && cd $_
yo gulp-angular
	*if fails: bower-install  / npm i

==============================================================