<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ButtonController;

    Route::apiResource('/employee',App\Http\Controllers\Api\EmployeeController::class);
    Route::apiResource('/supplier',App\Http\Controllers\Api\SupplierController::class);
    Route::apiResource('/category',App\Http\Controllers\Api\CategoryController::class);
    Route::apiResource('/products',App\Http\Controllers\Api\ProductController::class);
    Route::apiResource('/pos',App\Http\Controllers\Api\PosController::class);
    Route::apiResource('/customer',App\Http\Controllers\Api\CustomerController::class);
    Route::apiResource('/cart',App\Http\Controllers\Api\CartController::class);
    // Route::get('/cart','Api\ButtonController@index');
    // Route::get('/cart/{id}','Api\ButtonController@show');
    // Route::delete('/cart/{id}','Api\ButtonController@destroy');

     Route::get('/cart/increment/{id}',[ButtonController::class,'increment']);
     Route::get('/cart/decrement/{id}',[ButtonController::class,'decrement']);


    Route::post('register', [UserController::class,'register']);//'UserController@register'
    Route::post('login',[UserController::class,'authenticate'] );//'UserController@authenticate'
    Route::post('logout',[UserController::class,'logout']);
    Route::get('open',[DataController::class,'open'] );//'DataController@open'

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', [UserController::class,'getAuthenticatedUser']);//'UserController@getAuthenticatedUser'
        Route::get('closed',[DataController::class,'closed'] );//'DataController@closed'
    });