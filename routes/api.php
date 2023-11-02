<?php

use App\Exceptions\CustomValidationException;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', function () {
    $names = User::all()->reject(function (User $user) {
        return $user->google_id != null;
    })->map(function (User $user) {
        return $user;
    });
    return $names;
});

// Route::get('/user/{id}', function ($id) {
//     $user = User::find($id);
//     return $user->name;
// });

Route::get('/posts/key', function () {
    return new PostCollection(Post::paginate());
});

Route::get('/user/res', function () {
    return (UserResource::collection(User::all()))
            ->response()
            ->header('X-Value', 'True');
});

Route::get('/rest', function (Request $request) {
    
    try{
        $request->validate([
            'name' => 'string|max:12',
            'family' => 'string|max:12'
        ]);
        
    } catch (ValidationException $e) {
        throw new CustomValidationException($e);
    }

});