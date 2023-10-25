<?php

namespace App\Http\Controllers;

use App\Models\ModelHasRoles;
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
        $roles = DB::select('SELECT * FROM roles');
        $users = User::all();
        $users = DB::select('SELECT users.name, users.email, users.id, R.name AS role
                             FROM users 
                             JOIN model_has_roles AS MHR ON MHR.model_id = users.id 
                             JOIN roles AS R ON R.id = MHR.role_id'
        );
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
