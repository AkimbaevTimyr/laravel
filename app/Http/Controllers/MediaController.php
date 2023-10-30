<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $media = DB::select("SELECT F.id, F.post_id, F.path FROM files F JOIN posts WHERE F.post_id = posts.id AND posts.author_id = :id;",
                                ['id' => $id]
        );

        // $media = Media::join('posts', function($q) use($id) {
        //     $q->on('files.post_id', '=', 'posts.id')
        //         ->on('posts.author_id', '=', "$id");
               
        // })
        // ->select('files.*')
        // ->get();
        
        return Inertia::render('Media/Media', [
            'media' => $media,
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            "folder_name" => 'string',
            "file_name" => 'string'
        ]);
        
        $folderName = $request->folder_name; 
        $fileName = $request->file_name;

        return Storage::download("$folderName/$fileName");
    }
}
