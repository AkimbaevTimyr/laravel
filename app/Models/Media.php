<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $fillable = ['id', 'post_id', 'path', 'created_at', 'updated_at'];
}
