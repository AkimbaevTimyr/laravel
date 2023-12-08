<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;


class UserService
{
    public function search($id)
    {
        $user = User::find($id);
        if(!$user) {
            throw new ModelNotFoundException('Пользователь с данным id не найден: ' . $id);
        }
        return $user;
    }
}