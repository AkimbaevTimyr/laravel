<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $posts = Post::getPostsByAuthor($request->id);

        try{
            $user = $this->userService->search($request->id);
        } catch(ModelNotFoundException $e) {
            return Inertia::render('Errors/NotFound', ['message' => $e->getMessage()]);
        }
        return Inertia::render('User/UserPage', [
            "posts" => $posts,
            "user" => $user
        ]);
    }
}
