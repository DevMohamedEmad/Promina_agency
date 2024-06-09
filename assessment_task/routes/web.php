<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/album/create', [App\Http\Controllers\albumController::class, 'create'])->name('albums.create');
Route::post('/album/store', [App\Http\Controllers\albumController::class, 'store'])->name('albums.store');
Route::get('/album/show/{id}', [App\Http\Controllers\albumController::class, 'show'])->name('albums.show');
Route::get('/album/edit/{id}', [App\Http\Controllers\albumController::class, 'edit'])->name('albums.edit');
Route::put('/album/update', [App\Http\Controllers\albumController::class, 'update'])->name('albums.update');
Route::post('/album/delete', [App\Http\Controllers\albumController::class, 'delete'])->name('albums.delete');
Route::post('/album/all', [App\Http\Controllers\albumController::class, 'getAlbumsToMoveImagesFromSpecificAlbumToAnother'])->name('getAlbums');
