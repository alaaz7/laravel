<?php
use App\Http\Controllers\Front\kkcontroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test1', function () {
    return 'welcome';
});

// Route required Parameters example

Route::get('/test2/{id}', function ($id) {
    return $id;
});

// Route Parameters with Default example

Route::get('/test3/{id?}', function () {
    return  'welcome';
});

// route with name for routers example 
Route::get('/test4/{id}', function ($id) {
    return $id;
})-> name('a');

Route::get('/test5/{id?}', function () {
    return  'welcome';
})-> name('b');


///////////  Naming Routing and Namespaces ///////////

Route::namespace('Front')->group(function (){

    //All route only accses controller or mehodes in folder name Front 
     //@ mean call with name @...
     //Route::get('/user',[kkcontroller::class,'showUserNames']);
     Route::get('user','kkcontroller@showUserNames');
});



////////////////////////////////////////////////////
//'middleware' => 'auth'] لحماية الموقع معناها بس الناس يلي مسموحلها تفوت عالرابط بتفوت غير هيك لا بحوله عصفحة تسجيل الدخول
Route::group(['prefix' => 'users', 'middleware' => 'auth'],function(){

    Route::get('/',function(){
return 'work';
    });
    Route::get('show','gg@showUserNames');
    Route::delete('delete','gg@showUserNames');
    Route::get('edit','gg@showUserNames');
    Route::put('update','gg@showUserNames');  

    
});

Route::get('login',function(){
    return 'must be auth to acsess this route';
        }) -> name('login');
//another way for middleware
/*Route::get('forperson',function(){
    return 'with auth';
})-> middleware('auth');*/

//Route::get('second','Admin\SecondController@showstring');

Route::group(['namespace' => 'Admin'],function (){
//عند وضع الميدلوير على راوت واحد يطبق على راوت واحد فقط
     Route::get('second','SecondController@showstring0') -> middleware('auth');
     Route::get('second1','SecondController@showstring1') ;
     Route::get('second2','SecondController@showstring2') ;
     Route::get('second3','SecondController@showstring3') ;
});


// route resourses get , post , destroy , edit ..

Route::resource('news','NewsController');
///////////////////////////////////////////////////////////


//call like this 
Route::get('index','Front\kkcontroller@getIndex');
// or

Route::group(['namespace' => 'Front'],function(){

    Route::get('indexx','kkcontroller@getIndex');
    Route::get('landing','kkcontroller@getlanding');
    Route::get('about','kkcontroller@getabout');

});

Auth::routes(['verify'=> true]); // [verify => true] عشان ما اخليه يعمل لوقن مباشرة لا ببعثله ايميل ولازم يأكد على الايميل لحتى اسمحله يدخل

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified'); // يلي داخل لازم يكون aut + verfied by email

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'])->name('home');

// to manuiplate model offer #45 lession
Route::get('fillable','CrudController@getOffers');


// this group to manuiplate offer insert , update , delete #46 lession
// add language selector for your route like this 
Route::group(['prefix' => LaravelLocalization::setLocale(),
             'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){
   

Route::group(['prefix' => 'offers'],function(){

    Route::get('store','CrudController@store');


    Route::get('create','CrudController@create');
    Route::get('all','CrudController@getAllOffers');

    Route::get('edit/{offer_id}','CrudController@editOffer');
    Route::post('update/{offer_id}','CrudController@UpdateOffer')-> name('offers.update');;

    Route::post('save','CrudController@save')-> name('offers.save');

});

});