<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationsDynamicController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $posts = Post::getPostsWithFiles();
        $authors = User::all();
        return Inertia::render('Welcome', ['posts' => $posts, 'authors' => $authors]);
    });

    Route::get('login/google/callback', [OAuthController::class, 'googleCallback'])->name('login.google-callback');
    Route::get('login/github/callback', [OAuthController::class, 'githubCallback'])->name('login.github-callback');

    Route::get('/login/oauth', [OAuthController::class,'OAuthApiLogin'])->name('login.oauth');

    Route::post('/create-comment/{id}', [CommentController::class, 'create'])->name('comment.create');
    Route::delete('/delete-comment/{id}', [CommentController::class,'delete'])->name('comment.delete');

    Route::get('/publication/{id}', [PostController::class, 'publication'])->name('post.publication');

    Route::get('/user/{id}', [UserController::class, 'index'])->name('user.index');

});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $user->load('roles');
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function (){
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::get('/post-edit/{id}', [PostController::class, 'edit'])->name('post.edit');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post-destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::patch('/post-update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::post('/set-visible/{id}', [PostController::class, 'setVisible'])->name('post.visible');
});

Route::get('/posts-filter/{id}', [PostController::class, 'filterPosts'])->name('posts.filter');

Route::group(['middleware' =>  ['auth', 'role:user']], function () {
    Route::get('/dynamic', [PublicationsDynamicController::class, 'index'])->name('dynamic');
    Route::post('/dynamic-get-posts', [PublicationsDynamicController::class, 'get'])->name('dynamic.get');
});

// Route::group(['middleware' => ['auth', 'role:moderator']], function () {
Route::group(['middleware' => ['auth']], function () {
    Route::get('/media', [MediaController::class, 'index'])->name('media');
    Route::get('/media-download/{folder_name}/{file_name}', [MediaController::class, 'download'])->name('media.download');
});

Route::group(['middleware' => ['auth', 'role:moderator']], function () {
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::put("/update-role/{id}/{role_id}", [RolesController::class, 'updateRole'])->name('roles.update-role');
    Route::post('/create-role', [RolesController::class, 'store'])->name('roles.store');
});


require __DIR__.'/auth.php';
require __DIR__.'/product.php';



