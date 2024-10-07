<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DailyCheckController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CheckInCheckOutController;

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
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [PageController::class , 'dashboard'])->name('dashboard');

    Route::resource('/employees', EmployeeController::class);

    Route::resource('/departments', DepartmentController::class);

    Route::resource('/roles', RoleController::class);

    Route::resource('/permissions', PermissionController::class);

    Route::resource('/project', ProjectController::class);

    Route::resource('/payroll', PayrollController::class);
    Route::get('/payroll-overview-table', [PayrollController::class, 'payrolloverviewTable'])->name('payroll.payroll-overview-table');
    Route::get('/my-payroll-overview-table', [PayrollController::class, 'myOverviewTable'])->name('my-attendance-overview-table');

    Route::resource('/salary', SalaryController::class)->only(['index' ,'create','edit', 'update', 'destroy' , 'store']);

    Route::resource('/company-setting',CompanyController::class)->only(['index' ,'edit', 'update', 'destroy']);

    Route::resource('/check-in/check-out', CheckInCheckOutController::class);

    Route::resource('/attendance', AttendanceController::class);
    Route::get('/attendance-overview-table', [AttendanceController::class, 'overviewTable'])->name('attendance.attendance-overview-table');
    Route::get('/attendance-history', [AttendanceController::class, 'attendanceHistory'])->name('attendance.attendance-history');
    Route::get('/my-attendance-overview-table', [AttendanceController::class, 'myOverviewTable'])->name('my-attendance-overview-table');

    Route::get('/scan-qr', [DailyCheckController::class, 'index'])->name('dailycheckin.index');
    Route::post('/scan-qr', [DailyCheckController::class, 'scanQr'])->name('dailycheckin.scanQr');

    /**
     * filepond Upload
     * api Route
     */
    Route::post('/upload' ,[UploadController::class , 'store']);
    Route::delete('/destory' ,[UploadController::class , 'destory']);
    Route::post('/upload-multi' ,[UploadController::class , 'storeMulti']);
    Route::post('/upload-files' ,[UploadController::class , 'storeFiles']);
    Route::delete('/destory-images' ,[UploadController::class , 'destoryImages']);
    Route::delete('/destory-files' ,[UploadController::class , 'destoryFiles']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
