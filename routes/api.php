<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RecipeController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\MetricController;
use App\Http\Controllers\API\NutritionController;
use App\Http\Controllers\API\SpecialEventsController;

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

    Route::middleware('auth:sanctum')->group(function () {
        // return $request->user();
                

                Route::post('/addProducts', [ProductController::class, 'store']);
                Route::delete('/deleteProducts/{id}', [ProductController::class, 'destroy']); 

                Route::post('/addRecipe', [RecipeController::class, 'store']);
                Route::put('/updateRecipe/{id}', [RecipeController::class, 'update'], function (Request $id) {
                    return 'Recipe '.$id;
                });
                Route::delete('/deleteRecipe/{id}', [RecipeController::class, 'destroy']);



                Route::post('/addEvent', [SpecialEventsController::class, 'store']);
                Route::put('/updateEvent/{id}', [SpecialEventsController::class, 'update'], function (Request $id) {
                    return 'Recipe '.$id;
                });
                Route::delete('/deleteEvent/{id}', [SpecialEventsController::class, 'destroy']);  


                //Nutrition

                Route::post('/nutritionPlan', [NutritionController::class, 'store']);
                Route::put('/updateNutritionPlan/{id}', [NutritionController::class, 'update'], function (Request $id) {
                    return 'Recipe '.$id;
                });
                Route::delete('/deleteNutritionPlan/{id}', [NutritionController::class, 'destroy']); 


                ////ADMIN FUNCTION
                Route::post('/addAdmins', [AdminController::class, 'register']);

                Route::put('/addMetrics/{id}', [MetricController::class, 'update']);


    });





Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login'])->name('login');

Route::get('logout', function () {
    Auth::logout();
    return response()->json(['message'=>'User Sucsesfully Logged Out']);
    return redirect('/');
});



Route::get('allProducts', [SpecialEventsController::class, 'index']);

Route::get('products/{id}', [ProductController::class, 'show'], function (Request $id) {
    return 'Products '.$id;
});



Route::get('Recipe/{id}', [RecipeController::class, 'show'], function (Request $id) {
    return 'Recipe '.$id;
});

Route::get('event/{id}', [SpecialEventsController::class, 'show'], function (Request $id) {
    return 'Events '.$id;
});

Route::get('nutritionPlan/{id}', [NutritionController::class, 'show'], function (Request $id) {
    return 'Events '.$id;
});