<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Roles extends Model
{
    protected $table = "roles";
    protected $fillable = ['id', 'name', 'guard_name', 'created_at', 'updated_at'];
}