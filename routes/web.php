<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopHeadlinesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SourcesController;
use App\Http\Controllers\UserFavoritesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [TopHeadlinesController::class, 'welcome']);

Route::middleware('auth')->group(function () {
    //Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //TopHeadlines
    Route::get('/topHeadlines', [TopHeadlinesController::class, 'index'])->name('topHeadlines');
    //Everything
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    //Sources
    Route::get('/sources', [SourcesController::class, 'index'])->name('sources');
    //Favorites
    Route::get('/favorites', [UserFavoritesController::class, 'index'])->name('favorites');
    Route::post('/favorites', [UserFavoritesController::class, 'store']);
    Route::delete('/favorites/{favorite_id}', [UserFavoritesController::class, 'destroy']);
    //Comments
    Route::get('/comments', [CommentsController::class, 'index'])->name('comments');
    Route::post('/comments', [CommentsController::class, 'store']);
    Route::patch('/comments/{comment_id}', [CommentsController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment_id}', [CommentsController::class, 'destroy']);
});

Route::middleware('auth', 'App\Http\Middleware\Admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/comments', [AdminController::class, 'getComments'])->name('admin.comments');
    Route::get('/admin/favorites', [AdminController::class, 'getFavorites'])->name('admin.favorites');
    Route::get('/admin/profile', [AdminController::class, 'getProfile'])->name('admin.profile');
    Route::get('/admin/logs', [AdminController::class, 'getUserLogs'])->name('admin.logs');
});


require __DIR__.'/auth.php';
