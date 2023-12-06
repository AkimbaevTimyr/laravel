<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:64',
            'comment' => 'required'
        ]);

        PostComment::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'post_id' => $request->id
        ]);
    }

    public function delete(Request $request)
    {
        PostComment::where('id', $request->id)->delete();
    }
}
