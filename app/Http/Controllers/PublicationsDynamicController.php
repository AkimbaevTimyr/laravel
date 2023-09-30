<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PublicationsDynamicController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $posts = DB::select(' SELECT author,
                                    COUNT(*) AS post_count,
                                    Date(created_at) AS post_date FROM posts
                                    WHERE author_id = :id GROUP BY author, post_date;',
                                    ['id' => $id]);
        return Inertia::render('PublicationsDynamic/PublicationDynamic',[
            'posts' => $posts,
        ]);
    }

    public function get(Request $request)
    {
        $id = Auth::user()->id;
        $posts = Post::where('author_id', $id)->where('created_date', $request->date);
        return ['xui' => $request['date']];
    }
}
