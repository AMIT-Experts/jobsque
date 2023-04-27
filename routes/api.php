<?php

use App\Http\Controllers\ApplysController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompanyssController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperinceController;
use App\Http\Controllers\FavoraitsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UsersController;
use App\Models\companyss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>['auth:sanctum']],function(){
 //user
    /* auth */
    Route::get('auth/profile/{id}',[UsersController::class, 'user']);
    Route::get('auth/logout',[UsersController::class, 'logout']);
    Route::get('auth/otp/{email}', [UsersController::class,'show']);
    Route::put('auth/user/update/{id}',[UsersController::class, 'update']);
/* auth */



/* profile */
Route::put('user/profile/{id}',[ProfilesController::class, 'store_main']);
Route::put('user/profile/edit/{id}',[ProfilesController::class, 'edit_profile']);
Route::put('user/profile/language/{id}',[ProfilesController::class, 'edit_profile_lang']);
Route::post('user/profile/portofolios/{id}',[ProfilesController::class, 'add_portofolio']);
Route::get('user/profile/portofolios/{id}',[ProfilesController::class, 'get_portofolio']);
Route::get('user/profile/show/{id}',[ProfilesController::class, 'show']);
Route::delete('user/profile/portofolios/{id}',[ProfilesController::class, 'delete_portofolio']);
Route::put('user/profile/portofolios/{id}',[ProfilesController::class, 'edit_portofolio']);
Route::put('user/profile/personaldetails/{id}',[ProfilesController::class, 'edit_details']);

/* profile */



/* jobs */
Route::post('jobs/add',[JobsController::class, 'store']);
Route::get('jobs',[JobsController::class, 'show']);
Route::get('jobs/{id}',[JobsController::class, 'showjobid']);
Route::get('jobs/sugest/{id}',[JobsController::class, 'show_sugest']);
Route::get('jobs/search',[JobsController::class, 'search_jobs']);
Route::get('jobs/filter',[JobsController::class, 'filter_jobs']);
/* jobs */



/* favoriyes */
Route::post('favorites',[FavoraitsController::class, 'store']);
Route::get('favorites/{id}',[FavoraitsController::class, 'show_fav']);
Route::delete('favorites/{id}',[FavoraitsController::class, 'destroy']);

/* favortes */



/* educ */
Route::post('education',[EducationController::class, 'store']);
Route::get('education/{id}',[EducationController::class, 'show']);
Route::put('education',[EducationController::class, 'edit']);

/* educ */

/* experince */
Route::post('experince',[ExperinceController::class, 'store']);
Route::put('experince/{id}',[ExperinceController::class, 'edit']);
Route::get('experince/{id}',[ExperinceController::class, 'show']);
/* experince */

/* apply */
Route::post('apply',[ApplysController::class, 'store']);
Route::put('apply',[ApplysController::class, 'update']);
Route::get('apply/{id}',[ApplysController::class, 'show']);

/* apply */

/* company */
Route::post('company',[CompanyssController::class, 'store']);

/* company */


/* chat */
Route::post('chat/user',[ChatController::class, 'store_user']);
Route::post('chat/company',[ChatController::class, 'store_comp']);
Route::get('chat',[ChatController::class, 'show_chat']);

/* chat */

/* notification */
Route::get('notification/{id}',[NotificationController::class, 'show']);
/* notification */

});

/* auth */
Route::post('auth/register',[UsersController::class, 'register']);
Route::post('auth/login',[UsersController::class, 'login']);
/* auth */


