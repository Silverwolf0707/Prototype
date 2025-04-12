<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\PatientRecordsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ChangePasswordController;

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    // Home route
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // Audit Logs
    Route::resource('audit-logs', AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Patient Records
    Route::delete('patient-records/destroy', [PatientRecordsController::class, 'massDestroy'])->name('patient-records.massDestroy');
    Route::post('patient-records/parse-csv-import', [PatientRecordsController::class, 'parseCsvImport'])->name('patient-records.parseCsvImport');
    Route::post('patient-records/process-csv-import', [PatientRecordsController::class, 'processCsvImport'])->name('patient-records.processCsvImport');
    Route::resource('patient-records', PatientRecordsController::class);
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    // Change password
    Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
    Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
    Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
});

