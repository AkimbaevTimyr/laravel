<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::join('files', 'files.post_id', '=', 'posts.id')
            ->where('posts.author_id', '=', $request->id)
            ->select('posts.*', 'files.path')
            ->get();
        $user = User::find($request->id);
        return Inertia::render('User/UserPage', [
            "posts" => $posts,
            "user" => $user
        ]);
    }
}
