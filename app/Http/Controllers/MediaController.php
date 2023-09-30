<?php

namespace App\Http\Controllers;

use App\Models\Media;
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
        return Inertia::render('Media/Media', [
            'media' => $media,
        ]);
    }

    public function download(Request $request)
    {
        $folderName = $request->folder_name; // Здесь $request->folder_name - имя папки
        $fileName = $request->file_name; // Здесь $request->file_name - имя файла

        return Storage::download("$folderName/$fileName");
    }
}
