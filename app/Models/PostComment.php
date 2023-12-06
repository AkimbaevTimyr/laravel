<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $table = "post_comments";

    protected $fillable = ["name", "comment", "created_at", "post_id", "updated_at"];

    // static function create()
}
