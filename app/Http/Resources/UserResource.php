<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;

class UserResource extends JsonResource
{
    public static $wrap = 'users';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'google_id' => $this->google_id,
            // 'secret-data' => $this->when($this->google_id, function () {
            //     return Media::all();
            // }),
            $this->mergeWhen($this->google_id, [
                'first-secret' => Media::all(),
                'second-secret' => 'value',
            ]),
            'posts' => PostResource::collection(Post::where('author_id', '=', $this->id)->get())
        ];
    }


    // public function withResponse(Request $request, JsonResponse $response): void
    // {
    //     $response->header('X-value', 'True');        
    // }

}
