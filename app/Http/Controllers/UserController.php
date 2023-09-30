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
//        $posts = Post::where('author_id', $request->id)->where('is_visible', 1)->get();
        $posts = DB::select('SELECT posts.*, files.path AS path FROM posts JOIN files WHERE posts.author_id = :author_id AND posts.is_visible AND files.post_id = posts.id',
            [
                'author_id' => $request->id,
            ]
        );
        $user = User::find($request->id);
        return Inertia::render('User/UserPage',[
            "posts" => $posts,
            "user" => $user
        ]);
    }
}
