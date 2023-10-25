<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = "posts";

    protected $fillable = ["id", "author", "title", 'author_id','description', 'created_at', 'is_visible'];

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

        Cache::put("posts:{$post->id}", $post);

        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $name = $file->hashName();
            $path = Storage::put("${name}", $file);
            $media = Media::create([
                'author' => '123',
                'post_id' =>  $post->id,
                'path' => $path
            ]);
        }
        Cache::put("files:{$media->id}", $media);
    }

    static function updatePost($id = 0, $title = "", $description = ""): void
    {
        $post = self::find($id);
        if(!$post) {
            throw new \Exception('Post not found');
        }

        $post->update([
            'title' => $title,
            'description' => $description
        ]);
    }
}
