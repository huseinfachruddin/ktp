<?php

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\Auth;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function(){
    $user = User::where('id','1')->first();
    $user = $user->syncRoles('admin');
    return $user;
});

// CHECK LICENCE 
Route::match(['get','post'],'/checking', [LicenceController::class,'checkLicence']);
Route::match(['get','post'],'/setting', [LicenceController::class,'setLicence']);

//Domain
Route::get('/domain',[DomainController::class,'getDomain']);
Route::delete('/domain/{id}',[DomainController::class,'deleteDomain']);

//Product
Route::get('/product',[ProductController::class,'getProduct']);
Route::get('/product/{id}',[ProductController::class,'detailProduct']);
Route::post('/product',[ProductController::class,'createProduct']);
Route::put('/product/{id}',[ProductController::class,'editProduct']);
Route::delete('/product/{id}',[ProductController::class,'deleteProduct']);

// USER API
// Route::get('/user',[UserController::class,'getUser']);
// Route::get('/user/{id}',[UserController::class,'detailUser']);
// Route::put('/user/{id}',[UserController::class,'editUser']);
// Route::delete('/user/{id}',[UserController::class,'deleteUser']);

// Route::get('/role',[RoleController::class,'getRole']);
// Route::get('/role/{id}',[RoleController::class,'detailRole']);
// Route::post('/role',[RoleController::class,'createRole']);
// Route::put('/role/{id}',[RoleController::class,'editRole']);
// Route::delete('/role/{id}',[RoleController::class,'deleteRole']);

Route::post('/register',[Auth::class,'register']);
Route::post('/login',[Auth::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function(){ 
    Route::get('/logout',[Auth::class,'logout']);
    
    // Profile
    Route::get('/profile',[ProfileController::class,'getProfile']);
    Route::put('/profile',[ProfileController::class,'editProfile']);
    Route::put('/profile/password',[ProfileController::class,'passwordProfile']);
    // User
    Route::get('/user',[UserController::class,'getUser']);
    Route::get('/user/{id}',[UserController::class,'detailUser']);
    Route::put('/user/{id}',[UserController::class,'editUser']);
    Route::delete('/user/{id}',[UserController::class,'deleteUser']);
    // Role
    Route::get('/role',[RoleController::class,'getRole']);
    Route::get('/role/{id}',[RoleController::class,'detailRole']);
    Route::post('/role',[RoleController::class,'createRole']);
    Route::put('/role/{id}',[RoleController::class,'editRole']);
    Route::delete('/role/{id}',[RoleController::class,'deleteRole']);

    // Licence
    Route::get('/licence',[LicenceController::class,'getLicence']);
    Route::get('/licence/{id}',[LicenceController::class,'detailLicence']);
    Route::post('/licence',[LicenceController::class,'createLicence']);
    Route::put('/licence/{id}',[LicenceController::class,'editLicence']);
    Route::delete('/licence/{id}',[LicenceController::class,'deleteLicence']);
    
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin',function(Request $request){
            return 'Ok';
        });
    });
});



