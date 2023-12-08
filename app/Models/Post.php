<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = "posts";

    protected $fillable = ["id", "author", "title", 'author_id', 'description', 'created_at', 'is_visible'];

    static function getUserPosts()
    {
        $author_id = Auth::user()->id;
        $posts = self::join('files', 'files.post_id', '=', 'posts.id')
            ->where('posts.author_id', '=', $author_id)
            ->orderBy('posts.created_at', 'desc')
            ->select('posts.*', 'files.path')
            ->get();
        return $posts;
    }

    static function createPost(Request $request)
    {
        $post = self::create([
            'author' => Auth::user()->name,
            'author_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->hashName();
            $path = Storage::put("${name}", $file);
            $media = Media::create([
                'post_id' =>  $post->id,
                'path' => $path
            ]);
        }
    }

    static function updatePost($id = 0, $title = "", $description = ""): void
    {
        $post = self::find($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }

        $post->update([
            'title' => $title,
            'description' => $description
        ]);
    }

    //$visible - 0 or 1
    static function getPostsWithFiles($visible = 1)
    {
        $posts = self::join('files', 'files.id', '=', 'posts.id')
            ->where('posts.is_visible', '=', $visible)
            ->select('posts.*', 'files.path')
            ->paginate();
        return $posts;
    }

    static function getPostsByAuthor($id)
    {
        $posts = Post::join('files', 'files.post_id', '=', 'posts.id')
            ->where('author_id', '=', $id)
            ->select('posts.*', 'files.path as path')
            ->paginate();
        return $posts;
    }

    static function getPostDataForAuthorAndDate($id)
    {
        return Post::select('author', DB::raw('COUNT(*) as post_count'), Db::raw('Date(created_at) as post_date'))
                    ->where('author_id', '=', $id)
                    ->groupBy('post_date', 'author')
                    ->get()
                    ->toArray();
    }
}
