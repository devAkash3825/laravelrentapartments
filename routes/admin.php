<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RenterController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\Admin\PropertyController;

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


Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'adminLogin'])->name('login');
    Route::post('/logged-in', [AuthController::class, 'adminLoggedIn'])->name('login.submit');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('cities', [GlobalController::class, 'getCities'])->name('get.cities.by.state');

    Route::group(['prefix' => 'renter'], function () {
        Route::get('add-renter', [RenterController::class, 'create'])->name('add.renter');
        Route::post('store-renter', [RenterController::class, 'store'])->name('store.renter');
        Route::get('active-renters', [RenterController::class, 'activeRenters'])->name('active.renter');
        Route::get('active-list', [RenterController::class, 'activeRentersList'])->name('renters.active.list');
        Route::get('inactive-renters', [RenterController::class, 'inactiveRenters'])->name('inactive.renter');
    });

    Route::group(['prefix' => 'property'], function () {
        Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('properties-datatable', [PropertyController::class, 'datatable'])->name('properties.datatable');
        Route::get('properties/search',[PropertyController::class, 'search'])->name('properties.search');
        
        // Property CRUD routes
        Route::get('add-property', [PropertyController::class, 'create'])->name('add.property');
        Route::post('store-property', [PropertyController::class, 'store'])->name('store.property');
        Route::get('properties/{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('properties/{id}', [PropertyController::class, 'update'])->name('properties.update');
        Route::put('properties/{id}/general', [PropertyController::class, 'updateGeneral'])->name('properties.update.general');
        Route::put('properties/{id}/additional', [PropertyController::class, 'updateAdditional'])->name('properties.update.additional');

        // Floor Plans routes
        Route::post('properties/{id}/floorplans', [PropertyController::class, 'storeFloorPlan'])->name('properties.floorplans.store');
        Route::put('properties/{id}/floorplans/{floorPlanId}', [PropertyController::class, 'updateFloorPlan'])->name('properties.floorplans.update');
        Route::delete('properties/{id}/floorplans/{floorPlanId}', [PropertyController::class, 'deleteFloorPlan'])->name('properties.floorplans.delete');

        // Galleries routes
        Route::post('properties/{id}/galleries', [PropertyController::class, 'storeGallery'])->name('properties.galleries.store');
        Route::post('galleries/{galleryId}/images', [PropertyController::class, 'uploadGalleryImage'])->name('galleries.images.upload');
        Route::delete('gallery-images/{imageId}', [PropertyController::class, 'deleteGalleryImage'])->name('galleries.images.delete');
        Route::put('gallery-images/{imageId}/default', [PropertyController::class, 'setDefaultImage'])->name('galleries.images.set-default');
    });
});
