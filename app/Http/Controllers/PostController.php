<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $posts = Post::getUserPosts();
        return Inertia::render('Posts/Posts', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'posts' => $posts,
            'role' => Auth::user()->getRoleNames(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:64|unique:posts',
            'description' => 'required|max:500',
            'file' => 'file|mimes:jpg,png|max:1024'
        ]);
        Post::createPost($request);
    }

    public function edit(Request $request)
    {
        $post = Post::find($request->id);
        return Inertia::render('Posts/PostPage', [
           'posts' => $post
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Post::destroy($request->id);
        return Redirect::route('posts');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'string|max:64',
            'description' => 'max:500',
        ]);
        Post::updatePost($request->id, $request->title, $request->description);
    }

    public function setVisible(Request $request)
    {
        $post = Post::find($request->id);
        if($post->is_visible == 1){
            $post->is_visible = 0;
        }else {
            $post->is_visible = 1;
        }
        $post->save();
    }
    public function publication(Request $request)
    {
        $id = $request->id;
        $post = Post::find($id);
        $comments = PostComment::where('post_id', $id)->get();
        return Inertia::render('Publication', [
            'posts' => $post,
            'comments' => $comments
        ]);
    }

    public function filterPosts(Request $request)
    {
        $request->validate([
            'id' => 'string'
        ]);
        $id = $request->id;
        if($id == '0')
        {
            $posts = Post::all();
        } else {
            $posts = Post::join('files', 'files.post_id', '=', 'posts.id')
                            ->where('author_id', '=', $id)
                            ->select('posts.*', 'files.path')
                            ->get();
        }
        return response()->json($posts);
    }
}
