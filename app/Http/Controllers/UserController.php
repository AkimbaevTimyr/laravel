<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::getPostsByAuthor($request->id);
        $user = User::find($request->id);
        return Inertia::render('User/UserPage', [
            "posts" => $posts,
            "user" => $user
        ]);
    }
}
