<?php

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
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/biens', [\App\Http\Controllers\PropertyController::class, 'index'])->name('property.index');
Route::get('/biens/{slug}-{property}', [\App\Http\Controllers\PropertyController::class, 'show'])->name('property.show')->where([
    'property' => $idRegex,
    'slug' => $slugRegex
]);
Route::post('/biens/{property}/contact', [\App\Http\Controllers\PropertyController::class, 'contact'])->name('property.contact')->where([
    'property' => $idRegex,
]);

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'doLogin']);
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/images/{path}', [\App\Http\Controllers\ImageController::class, 'show'])->where('path', '.*');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () use ($idRegex) {
    Route::resource('property', 'App\Http\Controllers\Admin\PropertyController')->except(['show']);
    Route::resource('option', 'App\Http\Controllers\Admin\OptionController')->except(['show']);
    Route::delete('picture/{picture}', [\App\Http\Controllers\Admin\PictureController::class, 'destroy'])->name('picture.destroy')
        ->where([
        'picture' => $idRegex
    ]);
});
