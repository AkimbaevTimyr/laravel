<?php

namespace App\Http\Controllers;

use App\Models\ModelHasRoles;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        $users = User::getUsersWithRole();

        return Inertia::render('Roles/Roles', [
            'roles' => $roles,
            'users' => $users
        ]);
    }
    public function updateRole(Request $request)
    {
        $id = $request->id;
        $role_id = $request->role_id;

        ModelHasRoles::updateRole($id, $role_id);
    }

    public function store(Request $request)
    {
        $rules = [
            'permission' => 'string|max:64',
            'name' => 'string|max:32|unique:roles'
        ];

        $messages = [
            'permission.string' => 'Поле permission должно являть строкой',
            'permission.required' => 'Поле permission должно быть заполненно',
            'name.unique' => 'Название роли должно быть уникальным'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $permission = $request->permission;
        $role = $request->name;

        $endPermission = Permission::create(['name' => $permission]);
        $endRole = Role::create(['name' => $role]);
        $endRole->givePermissionTo($endPermission);
    }
}
