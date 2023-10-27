<?php

namespace App\Http\Controllers;

use App\Models\ModelHasRoles;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        $users = User::all();
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
        $request->validate([
            'permission' => 'string|max:64',
            'role' => 'string|max:32|unique:roles'
        ]);
        
        $permission = $request->permission;
        $role = $request->role;

        $endPermission = Permission::create(['name' => $permission]);
        $endRole = Role::create(['name' => $role]);
        $endRole->givePermissionTo($endPermission);
    }
}
