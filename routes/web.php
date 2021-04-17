<?php

use App\Http\Controllers\AdminUniversityRegisterRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {
    
    //Common routes
    Route::name('home')->group(function(){

        //Users Login
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
        
        //Users Profile
        Route::get('/profile', [UserController::class, 'index'])->name('.profile');

        //update profile
        Route::patch('/profile-updated', [UserController::class, 'updateProfile'])->name('.profile-update');
    });

    //Super Admin Route
    Route::name('super-admin.')->middleware('role:super-admin')->group( function (){
        //super-admin accepted the Admin University request
        Route::post('/admin-univ-success-registered', [HomeController::class, 'createAdminUniv'])->name('admin-univ-success-registered');

        //super-admin dismissed the Admin University request
        Route::post('/admin-univ-dismissed', [HomeController::class, 'dismissedAdminUniv'])->name('admin-univ-dismissed');

        //super admin customized the users data
        Route::get('/show-all-users', [SuperAdminController::class, 'showAllUsers'])->name('users');

        //delete university admin
        Route::delete('/delete-user', [SuperAdminController::class, 'deleteUser'])->name('delete-user');
        
        //customize criteria
        Route::group(['prefix' => 'criteria'], function () {
            //show
            Route::get('/show', [SuperAdminController::class, 'showCriteria'])->name('show-criteria');
            
            //add
            Route::post('/add-criteria-success', [SuperAdminController::class, 'addNewCriteria'])->name('add-criteria');
            
            //update
            Route::patch('/update-criteria-success', [SuperAdminController::class, 'updateCriteria'])->name('update-criteria');

            //delete
            Route::delete('/delete-criteria-success', [SuperAdminController::class, 'deleteCriteria'])->name('delete-criteria');
        });
    });

    //Admin University Route
    Route::name('university.')->middleware('role:university-admin')->group(function (){
        //Admin University Register request
        Route::post('/register-success', [AdminUniversityRegisterRequestController::class, 'create'])->name('admin-create')->withoutMiddleware(['role:university-admin', 'auth']);
        
        //University Customized (edit data eg. the majors and profile)
        Route::get('/university-profile', [UniversityController::class, 'index'])->name('university-profile');

        //update university profile
        Route::patch('/university-profile-updated', [UniversityController::class, 'updateUniversityProfile'])->name('university-profile-update');

        //add new major
        Route::post('/new-major-added', [UniversityController::class, 'addNewMajor'])->name('add-new-major');
        
        //update major
        Route::patch('/major-updated', [UniversityController::class, 'updateMajor'])->name('update-major');

        //delete major
        Route::delete('/major-deleted', [UniversityController::class, 'deleteMajor'])->name('delete-major');
    });

    //User Student Route
    Route::name('student.')->middleware('role:user-student')->group(function (){
        Route::get('/show-universities', [StudentController::class, 'index'])->name('show-universities');
    });
}); 
