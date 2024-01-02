<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/verify-token',[AuthController::class,'verifyToken']);
Route::resource('/roles',RoleController::class);


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/change-profile-picture',[UserController::class,"changeProfilePicture"]);
//    Route::resource('/venues',VenueController::class);
//    Route::resource('/categories',CategoryController::class);
//    Route::resource('/formats',FormatController::class);
//    Route::post('/change-password',[AuthController::class,"changePassword"]);
//    Route::resource('/contactus',ContactController::class);
//    Route::get('/statistics',[StatisticsController::class,"index"]);
//    Route::get('/deleteContact/{id}',[ContactController::class,"deletecontact"]);
//    Route::resource('/courses',CourseController::class);
//    Route::resource('/schedules',ScheduleController::class);
//    Route::resource('/trainings',TrainingController::class);
//    Route::resource('/books',BookController::class);
//    Route::resource('/hero',HeroController::class);
//    Route::resource('/certificates',CertificateController::class);
//    Route::resource('/social-media',SocialMediaController::class);
//    Route::Post('/update-hero/{id}',[UserAccessDatasController::class,"updateHero"]);
//    Route::Post('/update-certification/{id}',[UserAccessDatasController::class,"updateCertification"]);
//    Route::get('/booked-courses',[UserAccessDatasController::class,'BookedCourses']);
//    Route::get('/admin-search-training',[AdminSearch::class,'AdminSearchTraining']);
});
