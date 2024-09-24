<?php

use App\Http\Controllers\Admin\AddressTypesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SettingController;
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

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login-check', [LoginController::class, 'loginCheck'])->name('login-check');

Route::group(['middleware' => ['auth:admin']], function () {

    //    Main Routes
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('my-profile', [ProfileController::class, 'index'])->name('my-profile');
    Route::post('updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::get('change-panel-mode/{id}', [DashboardController::class, 'changePanelMode'])->name('change-panel-mode');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard2', [DashboardController::class, 'index2'])->name('dashboard2');
    Route::get('/change-password', [PasswordController::class, 'index'])->name('change-password');
    Route::post('update-password', [PasswordController::class, 'updatePassword'])->name('update-password');

    Route::resource('products', ProductsController::class);
    Route::get('/get-products', [ProductsController::class, 'getDatatable'])->name('get-products');

    Route::resource('setting', SettingController::class);
    Route::get('/get-setting', [SettingController::class, 'getDatatable'])->name('get-setting');

    Route::resource('users', UsersController::class);
    Route::get('/get-users', [UsersController::class, 'getDatatable'])->name('get-users');

    Route::resource('address-types', AddressTypesController::class);
Route::get('/get-address-types', [AddressTypesController::class, 'getDatatable'])->name('get-address_types');
});
use App\Http\Controllers\Admin\PanelBrandsController;
Route::resource('panel-brands', PanelBrandsController::class);
Route::get('/get-panel-brands', [PanelBrandsController::class, 'getDatatable'])->name('get-panel_brands');

use App\Http\Controllers\Admin\QualityPreferencesController;
Route::resource('quality-preferences', QualityPreferencesController::class);
Route::get('/get-quality-preferences', [QualityPreferencesController::class, 'getDatatable'])->name('get-quality_preferences');
