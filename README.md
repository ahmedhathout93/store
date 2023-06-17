# store

PHP Laravel - Multivendor ecommerce :department_store:

Hello , my name is *Ahmed Hathout* , hope you doing well :smiley: <br>

This is my first Laravel project . I will try to note :memo: here my progress in project including more details . As this is first project you may find some non important steps or it can be used with exist plugin or function in Laravel but it is better know how it works and start from scratch .So we can say it is an educational project for me  ,  following *Mohammed Safadi* experienced PHP Laravel developer on  YouTube and you can view  playlist  :eyes:   [Here](https://www.youtube.com/playlist?list=PL13Ag2mfco64zMLcFjPb5GVWCu-OAjTrx)





|  Step :one:| Prepare admin dashboard | 
|--------------|-----------|
|  **Download AdminLTE3**  | :black_medium_square: Move dist and plugins folder to laravel public folder then create ***`resources/views/dashboard.blade.php`*** file      |
| **Create dashboard controller**      |:black_medium_square: Open an  terminal in VS Code and right : ***`php artisan make:controller DashboardController`*** , so this controller will be created at ***`app/http/controllers`***  then we create index method in this file that will return view action for dashboard .Now we can go to ***`routes/web.php`*** file and use route get method like ***`Route::get('/dashboard', [DashboardController::class, 'index']);`*** <br><br>:black_medium_square: remember : it is better to use laravel asset function in linking styling files to return reltive path to public folder ***`href=" {{asset('path')}}"`***|
|**Create dashboard layout and blade templates**|:black_medium_square: As there are many pages in dashboard or frontside that use common header and footer and sidebars .We can use general layout with common static parts and place ***`@yield('Content')`*** for the dynamic part then add on view pages <br> **`@extends('layout_file')`**<br> **`@section('content')`** <br> dynamic part <br> **`@endsection`** <br><br> :black_medium_square: we can use another method of inheritance in Laravel . In layout file we can write <br>**`@section('name')`**<br> static content<br> **`@show`** <br> then in view file :<br> **`@section('name')`**<br> **`@parent`**<br>Dynamic content<br>**`@endsection`**<br>so @parent will all and include static content and add new dynamic content , if we didn't write it this mean that we will override static content (OOP inheritance ).<br> <br>:black_medium_square: If we need to add some styling or script files in view files without overriding files in layout files we can use stack directive like : <br>  in layout side <br> **`@stack('styles')`** <br> in view side <br> **`@push('styles')`** <br> file link <br> **`@endpush`**  <br> <br>:black_medium_square: If you feel that main layout file is too large to deal with and search in you can divide it by creating subfolder in layouts and add partial files in it like nave or sidebar then include them in main file like : <br> **`@include('layouts.partials.nav')`**|
|**Configuration**|:black_medium_square: In beginning of request lifecycle Laravel loads all configuration files located in **`config`** folder .these files return an array of keys and these keys refers to value of environment variables like : <br> **`'key' => env ('environment var.' , 'default value')`** <br> these environment variables are defined in **`.env`** file . let's show :mag_right: some variables from this file : <br>:pencil2: **`APP_NAME = 'web app name'`** <br>:pencil2:**`APP_ENV = local/production`** <br> **local** : display error messages for developer to optimize app<br>**production** : not displaying error message to protect unauthorized persons from accessing codes<br>:pencil2:**`APP_DEBUG = true(local env)/false(production env)`** <br>:pencil2:**`APP_KEY = Random key for encrypting`** generated by Laravel or we can change or generate manually with this command <br> **`php artisan key:generate`**  <br> <br> :black_medium_square: Another important config key in **`config/app`** file <br>  **`'asset_url' => env('ASSET_URL')`** <br> if some resources like styling files not located in public folder on same server and placed in different URL we can define it in this key  <br> <br> :warning: **`env`** function in not recommended to be used outside config files because if we used config cache file , Laravel will not load env keys from .env file <br> **cache file** is a file created by command **`php artisan config:cache`** and located in **`Bootstarb/cache/config.php`** and contain all config files to speed configuration operation as laravel will stop reading form env file and use stored cache file .Instead of we will use key values from config files like **`{{config('app.name')}}`** <br><br>:warning: For the same previous reason it is recommended to create cache file at the end of project because if you made any modification in env file it will be ignored as it read from cache file|



<br><br>
|  Step :two:| Prepare database | 
|--------------|-----------|
|**Database configuration**|:black_medium_square: Database configuration keys located in **`config/database.php`** file .In our project we will use **`MYSQL`** so we will check only **`'mysql'`** array of connection parameters.<br> <br> :black_medium_square: In case we have to use to different databases with different host , we have to copy mysql array to another **`'mysql2`**' .Also we should copy **`DB`** parameters in **`.env`** file to **`DB2`**|
|**Create database**|:black_medium_square: Using **`phpMyAdmin`** or any tool we will create a database then write values to **`.env`** file <br>:pencil2:**`DB_CONNECTION=mysql`**<br>:pencil2:**`DB_HOST=127.0.0.1`**<br>:pencil2:**`DB_PORT=3306`**<br>:pencil2:**`DB_DATABASE=aqua_store`**<br>:pencil2:**`DB_USERNAME=root`**<br>:pencil2:**`DB_PASSWORD=root`**|
|**Analyze database and tables structure** |:black_medium_square: open a notepad file and start to write the basic tables and fields needed in your project .In our case for a multivendor ecommerce we need the following tables .<br>:books:**`categories ( id (PK) , parent_id(FK) , name , slug (UQ) ,...)`** <br>:books: **`stores ( id (PK) , name , ...)`**<br>:books: **`products ( id (PK) , store_id (FK) , category_id (FK), name , slug (UQ), description , price ...)`**<br>:books: **`orders ( id , number , user_id ,status ...)`**<br>:books: **`orders_items ( order_id (FK) , product_id , qty)`**<br>:books: **`cart ( will be discussed later)`**<br><br> Notes : <br> <br>:memo: PK :arrow_right: Primary  Key:heavy_minus_sign: FK :arrow_right: Foreign Key :heavy_minus_sign: UQ :arrow_right: UNIQUE<br><br>:memo: Slug : is a simplified version of string , typically URL and SEO friendly without (spaces, accented letters, ampersands, etc.) <br> <br>:memo: If you noticed we divided orders into 2 tables .Static fields in orders and others in orders_items **`why`** if any user purchased many items in on order , so (order id , number ,user_id , status) will be repeated for all purchased items that is why it is better to create another table orders_items and use foreign key order_id to bind all items to same order  |
|**Migrations**|:black_medium_square: Migrations enable developers to swiftly create, delete, and modify an application database without logging into the database manager or executing any SQL queries. So we create tables in laravel itself. <br><br>:black_medium_square: Migration files is created with command :<br> **`php artisan make:migration create_tableName_table`**<br> then migration file is created in **`database/migrations`**.<br><br> :black_medium_square: Migration file contains an unnamed class that consists of 2 methods **`up()`** , **`down()`**. <br><br> :black_medium_square: The `up` method is used to add new tables, columns, or indexes to your database, while the `down` method should reverse the operations performed by the `up` method . <br><br> :black_medium_square: Till now migration not completed. To migrate we write this command <br> **`php artisan migrate`** <br> then laravel will execute up methods in all migrations files.<br><br> :black_medium_square: If you tried to modify any column in table then migrate again you will get this message :**`Nothing to migrate`** so we can use this command to rollback **`php artisan migrate:rollback`** but this not recommended in production mode as it will drop table data|
|**Create models**|:black_medium_square: Normally model is created with following command : <br> **`php artisan make:model Name`** <br> also we can create a migration and model in same time with by adding **`-m`** to previous command <br><br> :warning: To match with Laravel autoloading , model name should be a single capitalized name from table name . So if table name is **`stores`** , model name should be **`Store`** . If you don't want to use good practice concepts and use different names , you should define this customization in model files  like : <br><br> **`protected  $table = 'stores'`** // table name ; .<br> **`protected $connection = 'mysql2';`** // if not using default connection. <br> **`protected $primaryKey = 'id'`** ; // if primary key has different name (not id). <br> **`public $increamenting = false;`** // if primary key not auto increment. <br> **`public $timestamps = false;`** //if you don't use timestamps() in table to avoid errors and laravel will not find create or updated field to insert data in .Also if you want to change name of created at or updated at , you can write : <br> **`const CREATED_AT = 'created_at' ;`**<br>**`const UPDATED_AT = 'updated_at' ;`** |
|**Data seeders**|:black_medium_square: Laravel provides a simple method to seed test data into a database using seeder classes. <br><br> :black_medium_square: to create database seeder : **`php artisan make:seeder UserSeeder`** .<br><br> :black_medium_square: Then UserSeeder file is created in `database/seeders`.and we can pass data in this file in **`run()`** method like <br> **`ModelName::create (['columnName' => 'value' , ...]`**.<br><br> :black_medium_square: If we deal with a table that don't have model , we can use this query builder method : <br> **`DB::table('name')-> insert([columnName' => 'value' , ...])`**<br><br> :black_medium_square: Then we go to **`DatabaseSeeder`** file and write in run method : **`$this->call(UserSeeder::class);`**<br><br> :black_medium_square: Finally we write command : **`php artisan db:seed`** to execute called seeders in **`DatabaseSeeder`** file |



<br><br> 

|  Step :three:| Authentication With Breeze starter kit | 
|--------------|-----------|
|**Installing**|:black_medium_square: Using Composer we can download breeze kit with following command : <br> **`composer require laravel/breeze --dev`** <br> --dev means using kit in developing stage only and package can be deleted after to optimize app storage. <br><br> :black_medium_square: Install breeze kit with command : **`php artisan breeze:install`** also you can remove package without affecting on created files with package with command **`composer remove laravel/breeze --dev`** <br><br> :black_medium_square: To use breeze kit we should first install **`node.js source code`** [Here](https://nodejs.org/en/download) then restart visual studio to detect nodejs . Now folder **`node_modules`** is created then we use command **`npm install`** then **`npm run build`** . build (production) means that js created files will be minified and this is suitable also in **`dev`** mode as we don't need to modify these files |
|**Customize**|:black_medium_square: Now we go to **`routes/web`** file we will find this code : <br>**`Route::get('/dashboard', function () {`** <br> **`return view('dashboard'); })`**<br>**`->middleware(['auth', 'verified'])`**<br>**`->name('dashboard')`**; <br> if you remember in step 1 we created a dashboard controller and now it is overrided again by breeze installation so now we should customize controller again as follows : <br> **`function () {return view ('dashboard');}`** :arrow_right: **`[DashboardController::class, 'index']);`** .<br> this mean if get request passed **`auth`** , **`verified`** middleware , will view our dashboard index page .<br>**`->name('dashboard');`** set name of route so we can call fixed name however we change route path .<br><br> :black_medium_square: We can get login user data to display it in dashoboard area using Facade class **`Auth`** as follows : <br> **`{{ Auth::user ( )->name }}`** facade class :: mode -> property or field <br><br> :black_medium_square: We can use directive @auth to excute code only for authenticated users like : <br> **`@auth`** <br > block of code <br> **`@endauth`** <br><br> :black_medium_square: We can use middleware in controller instead of route by adding construct method in controller as follows : <br> **`public function ــــConstruct  ( ) {`**<br> **`$this->middleware(['auth']);}`** <br> the benefit from this method that all controllers action will be checked by this middleware without needing to add it for every action .we can also add exception for this method **`->except('route')`** . Or specify **`->only('route')`** <br><br> :black_medium_square: For security , you will find logout route use post method to avoid **`csrf`** attacks so we can't use normal hyperlinks and logout action should be excuted by a form with **`post`** method <br><br> :black_medium_square: Also we should use directive **`@csrf`** inside any form and this will make laravel generate a random string will be stored in server and form to be compared to avoid attacks <br><br> :black_medium_square: To require email verifying for users , we go to **`models/user`** file and add **`implements MustVerifyEmail`** to user class . then go to **`.env`** file to modify email configuration. For testing we will change **`MAIL_MAILER =log`** and this will store messages in **`storage/logs/laravel.log`** file   | 



<br><br> 
|  Step :four:| CRUD & Resource controllers & Route | 
|--------------|-----------|
|**Creating categories controller** |:black_medium_square: Using command **`php artisan make:controller Dashboard\CategoriesController -r`** <br> this time we added **`Dashboard\`** to organize all needed dashboard controllers in separated namespace like Breeze kit made Auth directory . <br> **`-r`** -> resource controller : a controller consists of 7 built basic methods for CRUD operations ( <br>`index` : Listing categories <br> `create` : Form <br> `store` : Form action<br> `show` , `edit` ,`update` , `destroy` ) <br><br> :black_medium_square: In each method in this controller we return the needed view file like **`return view ('dashboard.categories.index');`** <br><br> :black_medium_square: To execute these view action we have to create routes .Also to organize **`web`** route file , we can make another route file for dashboard and include it in web file .We can write the route of 7 methods in one command <br> **`Route::resource('dashboard/categories' , CategoriesController::class);`** |
|**`Categories index , create and store pages`**| :black_medium_square: Edit routes can be used with **`get`** method like links but **`Delete`** and **`PUT`** and **`POST`** should be used with form only with type **`post`** and **`CSRF`** protection .How to know resources routes type ?! we can use the following command to show all routes in project **`php artisan route:list`** .If you have an error while using delete actions as received method from form is post so we will use this directive **`@method('delete')`** and this is called **`method spoofing`** <br><br> :black_medium_square: search for `@forelse` and `@empty` directives <br><br> :black_medium_square: Then we design `create` page with form contains categories details which will send it `store` page with post method  <br><br> :black_medium_square: In store method we should make validation then write in database but we will discuss validation in separate step .How create method fetch data from create form ?. see the next expressions <br>:heavy_check_mark: `$request-> input('name');` <br>:heavy_check_mark:  `$request-> post('name');`<br>:heavy_check_mark: `$request-> query('name')` <br>:heavy_check_mark: `$request-> get('name')` <br>:heavy_check_mark: `$request-> name;` <br>:heavy_check_mark: `$request ['name'];` <br>:heavy_check_mark: `$request-> all( );`<br>:heavy_check_mark: `$request-> only(['name1', 'name2']);`<br>:heavy_check_mark: `$request-> except(['name1', 'name2']);` <br> but actually we use this code :<br> **`$category = Category(model)::create( $request-> all( ) )`** <br> this command get and store and save data in model. When we try to refresh/reload the web page, this sends another HTTP POST request to the server with the same data as just before. This may cause undesired results, such as duplicate web purchases or duplicate date in database. So we use **`PRG`** design pattern (Post redirect Get) <br> **`return Redirect::route('categories.index');`** <br><br> :black_medium_square: In model file we should define two protected arrays **`$fillable`** (whitelist inputs)  or**`$guarded`** (blacklist inputs). <br><br> :black_medium_square: If there is some input not included in form but will depend on some inputs like **`slug`** , we can add it to controller using <br> **`$request->merge(['slug'=>Str::slug( $request->post('name')]);`** <br><br> :black_medium_square: If some route require a variable like edit route should contain variable like category id so we should pass this variable in route method like **`{{ route ('categories.edit' ,[$category->id] }}`** <br><br> :black_medium_square: To add **`flash`** messages like (category created successfully ) we with PRG method like <br> **`return Redirect::route('categories.index')->with('success' , 'Category created!');`** <br> As this message will be shown in index page we go to index view page and use this code: <br> **`@if(session()->has('success'))`**<br> **`< div class="alert alert-success">{{session('success')}}</ div >`**<br>**`@endif`**<br><br> :black_medium_square: Search for Route group|
|**Categories edit , update and delete pages**|:black_medium_square: Edit page is like a copy of create page with shown values from database .Also form will send data to update page with post method and PUT spoofing .<br><br> :black_medium_square: We have to send also needed variables for edit page in edit method in controller file .For example we have to send $ parent variable to be shown in parent field but we have to except the current edited category id as category can't be parent of itself <br>  **`$ parents = Category::where ('id' , '< >' , $ id )-> get( ) ;`** <br><br> :black_medium_square: In new laravel versions we can use **`@selected`** and **`@checked`** directives to display selected or checked values for this category instead of if loops in native php.<br> **`@ checked($ category->status == 'active')`** <br> **`@ selected($ parent->id == $ category->parent_id)`**<br><br> :black_medium_square: Search for findOrFail|



<br><br> 
|  Step :five:| Filesystem and Handling File Uploads | 
|--------------|-----------|
|**Form**|:black_medium_square: If you used any file input inside form you should define this attribute **`enctype = "multipart/form-data"`**|
|**Controller**|:black_medium_square: **`if ( $ request -> hasFile ('image')){`** <br> **`$ file = $ request -> file ('image') ;`** <br> **`$ path = $ file ->store('uploads' , 'public');`** <br> store method contains of file upload directory ('upload') and storage disk ('public') which is located in **`storage/app`** and can be configured in .env file (local or public ) in our case we need it public to be viewed for clients . <br><br> :black_medium_square: Store methods control random names of files but if you want to control this name you can use **`storeAS`** method and search about it <br><br> :black_medium_square: But the problem now that we can't merge this input file with sent data from form as it already contains the same input name .So we have a solution to create another collection object <br> **`$ data = $ request ->except ('image');`**  <br> then assign image input with $ path <br> **`$ data ['image'] = $ path ;`** <br> then we send $ data in create or update methods not $ request->all() <br><br> :black_medium_square: If we updated image this mean that we will add a new image and the old image still exists uses more storage and increase backup size so we have to delete old image <br> **`$ old_image = $ category->image;`** <br> **`if ($ old_image && isset ( $ data ['image']){`** <br> **`Storage::disk('public')->delete ( $ old_image);}`** <br> Also we have to delete it from destroy method in controller <br><br> :black_medium_square: Till now uploaded images can't be shown in browser as it located outside main public folder of project .So we have to use this command **`php artisan storage:link`** this will create a shortcut of storage directory in public directory .|



<br><br> 
|  Step :six:| Request Validation | 
|--------------|-----------|
|**Validate() method**|:black_medium_square: Validation should be used before store and update action using validate method .We can pass an array of keys and values. The keys if form input names and values is the restricts or validation rules . Examples : <br> **`$ request -> validate([`**<br> **`'name' => 'required \|string\|min:3\|max:255'`** ,<br>**`'parent_id'=> ['int' ,'exists:categories,id'] ]);`** <br> <br> :black_medium_square: See laravel documentation for more validation examples for images and selection box ,etc...<br> <br> :black_medium_square: Search about **`@error`** and **`@class`** directive to show validation alerts in front side .<br><br> :black_medium_square: Repeating validation rules in store and edit method is not a good practice so we should define a static function in model and call it when needed .<br><br> :black_medium_square: We can customize error messages by passing array as second argument in validate() method like : <br> **`'unique'=> 'this name is already exists'`** also can specify input like **`'name. unique'`** .Also can mention field name in message using **`:attribute`**<br><br> :black_medium_square: Search about custom request and how to make custom validation rules. |
 

<br><br> 
|  Step :seven:| Blade components | 
|--------------|-----------|
|**Create component**|:black_medium_square: blade components is useful to write clean dynamic view codes and avoid repeating block of codes . component is created with command **`php artisan make : component alert --view`** <br><br> :black_medium_square: To call component use **`< x-alert type = "success"/ >`** and we can pass variables through attributes like type and in component file use $ type and {{$ type}} or :type ="$ variable" <br><br> :black_medium_square: We can use also directive **`@props()`** to pass expected attributes in this component with default values <br><br> :black_medium_square: Search for **`{{ $ attributes }}`** special variable .|
|**Class components**|class component is used we you need to write a logic code to display dynamic parts in page like list in navbar may contain icon , route , title for different links so we can use class component to pass this variables and create clean dynamic code . <br>**`php artisan make : component Nav`** <br> this command without -- view creates  class file in `app/view/components` and contains of 2 methods render and construct . render method is used to return the blade view file and construct is used to config this page using public variables defined in the same class file and created config file|
 



<br><br> 
|  Step :eight:| Pagination | 
|--------------|-----------|
|**Use pagination** |:black_medium_square: In index method in controller file we used `$ categories = Category :: all( )` .Now we replace all with `paginate (no. of items in page )`|
|**View pagination**|:black_medium_square: to view pagination control we go to view file and use links method **`{{ $ categories -> links( ) }}`** .This pagination is using tailwind by default so if you use bootstrap you go to `App/AppServiceProvider.php` in boot method and add **`Paginator :: useBootstrapFour( )`**|
|**Using filter or search**|:black_medium_square: Build a form with GET method and action `{{URL::current()}}` to send data to the same page<br><br> :black_medium_square: Then in index method in controller we make a query with search form data coming from `request` and `$ Category::query()` data from database model then use data coming from query and passing it through pagination **`$ query -> paginate(2)`**. <br><br> :black_medium_square: If you navigated pagination the filter queries will be lost so Laravel made a solution for this in view file <br> **`{{ $ categories -> withQueryString()-> links( ) }}`** |
|**Eloquent model local scope**|:black_medium_square: Applying filter queries in controller file is not a good practice as it increase file size and make code not clean .So we can use local scope concept and create scope method in model start with scope like **`scopeFilter`** and apply you queries filters there <br><br> :black_medium_square: There built in scopes in Laravel like **`-> latest ('name')`**  **`->orderBy('name , 'ASC')`**|
 



<br><br> 
|  Step :nine:| Soft deletes , global scope and factories| 
|--------------|-----------|
|**Soft deletes**|:black_medium_square: Soft delete mean removing or hiding data from app but not deleting from database so we can restore it if needed. it depend on adding new time stamp field to DB `deleted at` . So to add field we have to make new migration  <br> **`php artisan make:migration add _softDeletes_to_categories_table`**  <br> then in up method in migration file **`$ table -> softDeletes( )`**  and in down method **`$ table -> dropSoftDeletes( )`** <br> then in Category model file in class use trait `softDeletes` |
|**Factory**|:black_medium_square: Factories used to seed non real info to test app and the difference between factory and seeder that in seeder we write the data itself but in factory we write shape or format of data and factory generate it using `faker` . **`php artisan make:factory ProductFactory`** then we write in this file the format of data we need and then go to database Seeder file and write **`Product::factory (100) -> create( ) ;`**  then **`php artisan db:seed`**  <br><br> :black_medium_square: To avoid viewing other stores products to unauthorized users we create scope **`php artisan make:scope StoreScope`** and it will create scope file in model directory and write logic in it .Then in product model file we create static method **`booted ( )`** as this well be executed every time model used and write **`static::addGlobalScope('store' , new StoreScope() )`**|



<br><br> 
|  Step :one: :zero:| Relationships between models | 
|--------------|-----------|
|**Has many relationship**|:black_medium_square: Category has many products so we go to category model file and create public function that define this relation return `$ this->hasMany(Product::class , 'category_id' , 'id')` then go to Product model an create another function `return $ this->belongsTo (Category::class , 'category_id' , 'id')` then when we need to use this relation like display category name in product we write <br> $ **`product -> category ->name`** <br> you can notice that we didn't write ( ) after function name because this will make error as name is not a property in this method but when we remove brackets Laravel will use magic method to return category model which consists of name .<br><br> :black_medium_square: But this way we will make app slower as it make many queries in foreach loop in products so the solution is to load these data one time from the beginning when loading data from product model <br> **`$ products = Product::with(['category' , 'store'])-> paginate()`** and this is called `Eager Loading` |