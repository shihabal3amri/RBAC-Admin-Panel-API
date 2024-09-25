<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    public function createRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $role = Role::create(['name' => $request->name]);
        return response()->json($role, 201);
    }

    public function updateRole(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $role->update(['name' => $request->name]);
        return response()->json($role, 200);
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }

    public function createPermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    public function assignPermissionToRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $role = Role::find($request->role_id);
        $role->permissions()->attach($request->permission_id);

        return response()->json($role->permissions, 200);
    }

    public function assignRoleToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $authUser = Auth::user(); // Get the authenticated user
        $roleToAssign = Role::find($request->role_id); // Get the role to be assigned

        // Ensure that if the authenticated user is a moderator, they can only assign the 'moderator' role
        if ($authUser->hasRole('moderator') && $roleToAssign->name !== 'moderator') {
            return response()->json(['message' => 'Forbidden: Moderators can only assign the moderator role'], 403);
        }

        // Proceed with role assignment
        $user = User::find($request->user_id);
        $user->roles()->attach($roleToAssign->id);

        return response()->json($user->roles, 200);
    }

}
