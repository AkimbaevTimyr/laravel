<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\InspiniaController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationsDynamicController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $posts = DB::select('SELECT posts.*, files.path AS path FROM posts JOIN files WHERE posts.is_visible = 1 AND posts.id = files.id',);
        $postCollection = collect($posts);
        return Inertia::render('Welcome', ['posts' => $posts]);
    });

    Route::get('login/google', [GoogleLoginController::class, 'redirect'])->name('login.google-redirect');
    Route::get('login/google/callback', [GoogleLoginController::class, 'callback'])->name('login.google-callback');

    Route::post('/create-comment/{id}', [CommentController::class, 'create'])->name('comment.create');

    Route::get('/publication/{id}', [PostController::class, 'publication'])->name('post.publication');

    Route::get('/user/{id}', [UserController::class, 'index'])->name('user.index');
    Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function (){
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post-destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::patch('/post-update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::post('/set-visible/{id}', [PostController::class, 'setVisible'])->name('post.visible');
});

Route::middleware('auth')->group(function () {
    Route::get('/dynamic', [PublicationsDynamicController::class, 'index'])->name('dynamic');
    Route::post('/dynamic-get-posts', [PublicationsDynamicController::class, 'get'])->name('dynamic.get');
});

Route::middleware('auth')->group(function () {
    Route::get('/media', [MediaController::class, 'index'])->name('media');
    Route::get('/media-download/{folder_name}/{file_name}', [MediaController::class, 'download'])->name('media.download');
});


Route::middleware('auth')->group(function () {
    Route::get('/main',  [InspiniaController::class, 'index'])->name('inspinia.index');
});


Route::get('/redis', function () {
    $visits = Redis::incr('visits');
    return $visits;
});



require __DIR__.'/auth.php';


