<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function store(PostCreateRequest $request)
    {
        $request->validated();
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


    //1 visible
    //0 not visible
    public function setVisible(Request $request)
    {
        $post = Post::find($request->id);
        $post->is_visible = $post->is_visible == 1? 0 : 1;
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
        $posts = $id == '0' ? $posts = Post::getPostsWithFiles() :  $posts = Post::getPostsWithFiles($id);
        return response()->json($posts);
    }
}
