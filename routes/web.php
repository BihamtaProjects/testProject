<?php

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
//use App\Http\Controllers\Panel\UserController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::middleware('isAdmin')->group(function () {

Route::resource('roles', App\Http\Controllers\Panel\RolesController::class);
Route::resource('users', App\Http\Controllers\Panel\UsersController::class);
Route::resource('services', App\Http\Controllers\Panel\ServicesController::class);
Route::resource('subjects', App\Http\Controllers\Panel\SubjectsController::class);
Route::resource('pages', App\Http\Controllers\Panel\PagesController::class);

Route::resource('coventsessions', App\Http\Controllers\Panel\CoventsessionsController::class,['except' => 'index','create']);
    Route::get("/sessions/{covent}", 'App\Http\Controllers\Panel\CoventsessionsController@index')->name('coventsessions.index');
    Route::get("/sessions/create/{covent}", 'App\Http\Controllers\Panel\CoventsessionsController@create')->name('coventsessions.create');
Route::resource('curriculums', App\Http\Controllers\Panel\CurriculumsController::class,['except' => 'index','create']);
    Route::get("/curriculum/{covent}", 'App\Http\Controllers\Panel\CurriculumsController@index')->name('curriculums.index');
    Route::get("/curriculum/create/{covent}", 'App\Http\Controllers\Panel\CurriculumsController@create')->name('curriculums.create');
Route::resource('subcurriculums', App\Http\Controllers\Panel\SubcurriculumsController::class,['except' => 'index','create']);
    Route::get("/sub/{curriculum}", 'App\Http\Controllers\Panel\SubcurriculumsController@index')->name('subcurriculums.index');
    Route::get("/sub/create/{curriculum}", 'App\Http\Controllers\Panel\SubcurriculumsController@create')->name('subcurriculums.create');


//ajax
    Route::get("/user/role", 'App\Http\Controllers\Ajax\UsersController@search')->name('ajax.role.search');
    Route::get("/user/role/{id}", 'App\Http\Controllers\Ajax\UsersController@updateUser')->where('id', "[0-9]+")->name('ajax.user.role');

    Route::get("/covent/faq", 'App\Http\Controllers\Ajax\CoventsController@searchfaq')->name('ajax.faq.search');
    Route::get("/covent/faq/{id}", 'App\Http\Controllers\Ajax\CoventsController@updateCoventFaq')->where('id', "[0-9]+")->name('ajax.covent.faq');

    Route::get("/covent/keyword", 'App\Http\Controllers\Ajax\CoventsController@searchkeyword')->name('ajax.keyword.search');
    Route::get("/covent/keyword/{id}", 'App\Http\Controllers\Ajax\CoventsController@updateCoventKeyword')->where('id', "[0-9]+")->name('ajax.covent.keyword');

    Route::get("/covent/subject", 'App\Http\Controllers\Ajax\CoventsController@searchsubject')->name('ajax.subject.search');
    Route::get("/covent/subject/{id}", 'App\Http\Controllers\Ajax\CoventsController@updateCoventSubject')->where('id', "[0-9]+")->name('ajax.covent.subject');

    Route::get("/covent/instructor", 'App\Http\Controllers\Ajax\CoventsController@searchinstructor')->name('ajax.instructor.search');
    Route::get("/covent/instructor/{id}", 'App\Http\Controllers\Ajax\CoventsController@updateCoventInstructor')->where('id', "[0-9]+")->name('ajax.covent.instructor');

    Route::get("/covent/selected", 'App\Http\Controllers\Ajax\CoventsController@searchselected')->name('ajax.selected.search');
    Route::get("/covent/selected/{id}", 'App\Http\Controllers\Ajax\CoventsController@updateCoventSelected')->where('id', "[0-9]+")->name('ajax.covent.selected');
//end ajax




Route::get('/subSubjects/{subject}','App\Http\Controllers\Panel\SubjectsController@subSubjects')->name('subjects.subSubjects');

Route::Get('/user/{user}/role/{role}/destroy' ,'App\Http\Controllers\Panel\UsersController@destroyRole') ->name('usersRole.destroy');
Route::Get('/covent/{covent}/faq/{faq}/destroy' ,'App\Http\Controllers\Ajax\CoventsController@destroyFaq') ->name('coventFaq.destroy');
Route::Get('/covent/{covent}/instructor/{instructor}/destroy' ,'App\Http\Controllers\Ajax\CoventsController@destroyInstructor') ->name('coventInstructor.destroy');
Route::Get('/covent/{covent}/keyword/{keyword}/destroy' ,'App\Http\Controllers\Ajax\CoventsController@destroyKeyword') ->name('coventKeyword.destroy');
Route::Get('/covent/{covent}/subject/{subject}/destroy' ,'App\Http\Controllers\Ajax\CoventsController@destroySubject') ->name('coventSubject.destroy');
Route::Get('/covent/{covent}/selectedgroup/{selectedgroup}/destroy' ,'App\Http\Controllers\Ajax\CoventsController@destroySelectedgroup') ->name('coventSelectedgroup.destroy');
Route::Post('/user/search' ,'App\Http\Controllers\Panel\UsersController@search') ->name('users.search');



Route::get('/group/plans/{group_id}','App\Http\Controllers\Panel\ServicesController@plans')->name('services.plans');
Route::get('/group/addplan/{group_id}','App\Http\Controllers\Panel\ServicesController@addPlan')->name('services.plan.create');
Route::Post('/group/{group_id}/storeplan','App\Http\Controllers\Panel\ServicesController@storePlan')->name('services.plan.store');
Route::get('/editplan/{plan_id}','App\Http\Controllers\Panel\ServicesController@editPlan')->name('plan.edit');
Route::Post('/updateplan/{plan_id}','App\Http\Controllers\Panel\ServicesController@updatePlan')->name('plan.update');

Route::get('/plan/addprice/{plan_id}','App\Http\Controllers\Panel\ServicesController@addPrice')->name('plan.price.create');
Route::get('/plan/{plan_id}/prices','App\Http\Controllers\Panel\ServicesController@plansPrices')->name('services.plan.prices');
Route::Post('/plan/{plan_id}/destroy' ,'App\Http\Controllers\Panel\servicesController@destroyPlan')->name('plan.destroy');

Route::get('/editprice/{price_id}','App\Http\Controllers\Panel\ServicesController@editPrice')->name('price.edit');
Route::Post('/updateprice/{price_id}','App\Http\Controllers\Panel\ServicesController@updatePrice')->name('price.update');
Route::get('/addprice/{group_id}','App\Http\Controllers\Panel\ServicesController@addPrice')->name('price.create');
Route::Post('/storeprice/{price_id}','App\Http\Controllers\Panel\ServicesController@storePrice')->name('price.store');
Route::Post('/price/{price_id}/destroy' ,'App\Http\Controllers\Panel\servicesController@destroyPrice')->name('price.destroy');

Route::Get('/covents/{isEvent}','App\Http\Controllers\Panel\CoventsController@index')->name('covents.index');
Route::Get('/createCovents/{isEvent}','App\Http\Controllers\Panel\CoventsController@create')->name('covents.create');
Route::Post('/storeCovents/{isEvent}','App\Http\Controllers\Panel\CoventsController@store')->name('covents.store');
Route::Get('/showCovent/{isEvent}/{covent}','App\Http\Controllers\Panel\CoventsController@show')->name('covents.show');
Route::Post('/updateCovent/{isEvent}/{covent}','App\Http\Controllers\Panel\CoventsController@update')->name('covents.update');
Route::Post('/destroyCovent/{covent}/{isEvent}','App\Http\Controllers\Panel\CoventsController@destroy')->name('covents.destroy');

Route::Get('/successPayments','App\Http\Controllers\Panel\PaymentsController@successPayments')->name('successPayments.index');
Route::Post('/paymentsSearch','App\Http\Controllers\Panel\PaymentsController@PaymentsSearch')->name('successPayments.search');
});
