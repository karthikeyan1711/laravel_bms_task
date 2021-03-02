<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskEnquiryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobAssistantController;

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

Route::get('/',[UserController::class,'index'])->name('user_registration');
Route::post('user_registration/store',[UserController::class,'store_registration'])->name('store_registration');
Route::get('get_city',[UserController::class,'get_city'])->name('get_city');
Auth::routes(['register'=>false]);

Route::group(['middleware' => 'auth'], function()
{
	Route::get('enquiry-tasks',[TaskEnquiryController::class,'index'])->name('enquiry-tasks');
	Route::post('assignUser',[TaskEnquiryController::class,'assignUser'])->name('assignUser');
	Route::post('ReassignUser',[TaskEnquiryController::class,'ReassignUser'])->name('ReassignUser');

	Route::get('job-assitance',[AdminController::class,'index'])->name('job-assitance-list');
	Route::get('job-assitance/create',[AdminController::class,'create'])->name('create-job-assitance');
	Route::get('job-assitance/edit/{id}',[AdminController::class,'edit'])->name('edit-job-assitance');
	Route::post('job-assitance/update/{id}',[AdminController::class,'update'])->name('update-job-assitance');
	Route::post('job-assitance/store',[AdminController::class,'store'])->name('store-job-assitance');

	Route::get('job-assistan-tasks',[JobAssistantController::class,'index'])->name('job-assistan-tasks');
	Route::get('reject-job-assistan-tasks/{id}',[JobAssistantController::class,'RejectTask'])->name('reject-job-assistan-tasks');
	Route::get('accept-job-assistan-tasks/{id}',[JobAssistantController::class,'AcceptTask'])->name('accept-job-assistan-tasks');

	Route::get('/home', 'HomeController@index')->name('home');
});


