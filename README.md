# store

PHP Laravel - Multivendor ecommerce :department_store:

Hello , my name is _Ahmed Hathout_ , hope you doing well :smiley:

This is my first Laravel project* . I will try to note :memo: here my progress in project including more details . As this is first project you may find some non important steps or it can be used with exist plugin or function in Laravel but it is better know how it works and start from scratch .So we can say it is an educational project for me , following *Mohammed Safadi\* experienced PHP Laravel developer on YouTube and you can view playlist :eyes: [Here](https://www.youtube.com/playlist?list=PL13Ag2mfco64zMLcFjPb5GVWCu-OAjTrx)

| Step :one:                                      | Prepare admin dashboard                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| ----------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Download AdminLTE3**                          | :black_medium_square: Move dist and plugins folder to laravel public folder then create **_`resources/views/dashboard.blade.php`_** file                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| **Create dashboard controller**                 | :black_medium_square: Open an terminal in VS Code and right : **_`php artisan make:controller DashboardController`_** , so this controller will be created at **_`app/http/controllers`_** then we create index method in this file that will return view action for dashboard .Now we can go to **_`routes/web.php`_** file and use route get method like **_`Route::get('/dashboard', [DashboardController::class, 'index']);`_** <br><br>:black_medium_square: remember : it is better to use laravel asset function in linking styling files to return reltive path to public folder **_`href=" {{asset('path')}}"`_**                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| **Create dashboard layout and blade templates** | :black_medium_square: As there are many pages in dashboard or frontside that use common header and footer and sidebars .We can use general layout with common static parts and place **_`@yield('Content')`_** for the dynamic part then add on view pages <br> **`@extends('layout_file')`**<br> **`@section('content')`** <br> dynamic part <br> **`@endsection`** <br><br> :black_medium_square: we can use another method of inheritance in Laravel . In layout file we can write <br>**`@section('name')`**<br> static content<br> **`@show`** <br> then in view file :<br> **`@section('name')`**<br> **`@parent`**<br>Dynamic content<br>**`@endsection`**<br>so @parent will all and include static content and add new dynamic content , if we didn't write it this mean that we will override static content (OOP inheritance ).<br> <br>:black_medium_square: If we need to add some styling or script files in view files without overriding files in layout files we can use stack directive like : <br> in layout side <br> **`@stack('styles')`** <br> in view side <br> **`@push('styles')`** <br> file link <br> **`@endpush`** <br> <br>:black_medium_square: If you feel that main layout file is too large to deal with and search in you can divide it by creating subfolder in layouts and add partial files in it like nave or sidebar then include them in main file like : <br> **`@include('layouts.partials.nav')`**                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **Configuration**                               | :black_medium_square: In beginning of request lifecycle Laravel loads all configuration files located in **`config`** folder .these files return an array of keys and these keys refers to value of environment variables like : <br> **`'key' => env ('environment var.' , 'default value')`** <br> these environment variables are defined in **`.env`** file . let's show :mag_right: some variables from this file : <br>:pencil2: **`APP_NAME = 'web app name'`** <br>:pencil2:**`APP_ENV = local/production`** <br> **local** : display error messages for developer to optimize app<br>**production** : not displaying error message to protect unauthorized persons from accessing codes<br>:pencil2:**`APP_DEBUG = true(local env)/false(production env)`** <br>:pencil2:**`APP_KEY = Random key for encrypting`** generated by Laravel or we can change or generate manually with this command <br> **`php artisan key:generate`** <br> <br> :black_medium_square: Another important config key in **`config/app`** file <br> **`'asset_url' => env('ASSET_URL')`** <br> if some resources like styling files not located in public folder on same server and placed in different URL we can define it in this key <br> <br> :warning: **`env`** function in not recommended to be used outside config files because if we used config cache file , Laravel will not load env keys from .env file <br> **cache file** is a file created by command **`php artisan config:cache`** and located in **`Bootstarb/cache/config.php`** and contain all config files to speed configuration operation as laravel will stop reading form env file and use stored cache file .Instead of we will use key values from config files like **`{{config('app.name')}}`** <br><br>:warning: For the same previous reason it is recommended to create cache file at the end of project because if you made any modification in env file it will be ignored as it read from cache file |

<br><br>
| Step :two:| Prepare database |
|--------------|-----------|
|**Database configuration**|:black_medium_square: Database configuration keys located in **`config/database.php`** file .In our project we will use **`MYSQL`** so we will check only **`'mysql'`** array of connection parameters.<br> <br> :black_medium_square: In case we have to use to different databases with different host , we have to copy mysql array to another **`'mysql2`**' .Also we should copy **`DB`** parameters in **`.env`** file to **`DB2`**|
|**Create database**|:black_medium_square: Using **`phpMyAdmin`** or any tool we will create a database then write values to **`.env`** file <br>:pencil2:**`DB_CONNECTION=mysql`**<br>:pencil2:**`DB_HOST=127.0.0.1`**<br>:pencil2:**`DB_PORT=3306`**<br>:pencil2:**`DB_DATABASE=aqua_store`**<br>:pencil2:**`DB_USERNAME=root`**<br>:pencil2:**`DB_PASSWORD=root`**|
|**Analyze database and tables structure** |:black_medium_square: open a notepad file and start to write the basic tables and fields needed in your project .In our case for a multivendor ecommerce we need the following tables .<br>:books:**`categories ( id (PK) , parent_id(FK) , name , slug (UQ) ,...)`** <br>:books: **`stores ( id (PK) , name , ...)`**<br>:books: **`products ( id (PK) , store_id (FK) , category_id (FK), name , slug (UQ), description , price ...)`**<br>:books: **`orders ( id , number , user_id ,status ...)`**<br>:books: **`orders_items ( order_id (FK) , product_id , qty)`**<br>:books: **`cart ( will be discussed later)`**<br><br> Notes : <br> <br>:memo: PK :arrow_right: Primary Key:heavy_minus_sign: FK :arrow_right: Foreign Key :heavy_minus_sign: UQ :arrow_right: UNIQUE<br><br>:memo: Slug : is a simplified version of string , typically URL and SEO friendly without (spaces, accented letters, ampersands, etc.) <br> <br>:memo: If you noticed we divided orders into 2 tables .Static fields in orders and others in orders_items **`why`** if any user purchased many items in on order , so (order id , number ,user_id , status) will be repeated for all purchased items that is why it is better to create another table orders_items and use foreign key order_id to bind all items to same order |
|**Migrations**|:black_medium_square: Migrations enable developers to swiftly create, delete, and modify an application database without logging into the database manager or executing any SQL queries. So we create tables in laravel itself. <br><br>:black_medium_square: Migration files is created with command :<br> **`php artisan make:migration create_tableName_table`**<br> then migration file is created in **`database/migrations`**.<br><br> :black_medium_square: Migration file contains an unnamed class that consists of 2 methods **`up()`** , **`down()`**. <br><br> :black_medium_square: The `up` method is used to add new tables, columns, or indexes to your database, while the `down` method should reverse the operations performed by the `up` method |
