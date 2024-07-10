<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupAppointmentController;
use App\Http\Controllers\MeetingResponseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Authcontroller::class, 'login'])->name('login')->middleware('guest');
Route::post('loginPost', [Authcontroller::class, 'loginPost'])->name('loginPost');

// password recowet
Route::get('/recoverpw', [Authcontroller::class, 'recoverpw'])->name('recoverpw');
Route::post('/pwreset', [Authcontroller::class, 'pwreset'])->name('pwreset');

Route::get('/rsvp/{meetingId}/{response}', [MeetingResponseController::class, 'respond']);

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {


    //Profile route  
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('UpdateProfile', [UserController::class, 'UpdateProfile'])->name('update.profile');
    Route::post('changepassword', [UserController::class, 'UpdatePassword'])->name('update.password');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');

    // Appointment and Department routes
    Route::get('/', [AppointmentController::class, 'dashboard'])->name('dashboard');
    Route::get('/new-appointment', [AppointmentController::class, 'index'])->name('newappointment');
    Route::post('/aptstore', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/getaptByid', [AppointmentController::class, 'getaptByid'])->name('getaptByid');
    Route::get('/delete_appointment', [AppointmentController::class, 'delete'])->name('delete_appointment');

    // route for department
    Route::get('/department', [DepartmentController::class, 'index'])->name('department');
    Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/getdepartmentByid', [DepartmentController::class, 'getdepartmentByid'])->name('getdepartmentByid');
    Route::get('/deletedepartment', [DepartmentController::class, 'deletedepartment'])->name('deletedepartment');

    // group appointment
    Route::get('/groupappointment', [GroupAppointmentController::class, 'index'])->name('groupappointment');
    Route::get('/viewgrpapt/{id}', [GroupAppointmentController::class, 'viewgrpapt'])->name('viewgrpapt');
    Route::post('/aptgroupstore', [GroupAppointmentController::class, 'groupvisitorstore'])->name('appointmentgroup.store');

    // staff manage route
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/storestaff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/delete_staff', [StaffController::class, 'delete'])->name('delete_staff');
    Route::get('/getstaffByid', [StaffController::class, 'getstaffByid'])->name('getstaffByid');
    Route::get('/changePortalUser', [StaffController::class, 'changePortalUser'])->name('changePortalUser');


    //setting manage route
    Route::get('/setting', [SettingController::class, 'index'])->name('setting'); 
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    Route::post('/profile', [StaffController::class, 'profile'])->name('profile');
});
