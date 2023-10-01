<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PostController::class, 'index'])->name('post.index');

Route::prefix('posts')->
    middleware('auth')->group(function(){
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('', [PostController::class, 'store'])->name('post.store');
        Route::get('{post}', [PostController::class, 'show'])->name('post.show');
        Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('{post}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/category/{category}', [PostController::class, 'indexByCategory'])->name('post.index.category');
});
Route::prefix('categories')->
    middleware('auth')->group(function(){
        Route::get('index', [CategoryController::class, 'index'])->name('category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('category.show');
        Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});


Route::post('comments/store', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


require __DIR__.'/auth.php';
