<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Api\V1\{User,Role};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function updatePermissions(Role $role, Request $request)
    {
        $this->authorize('updatePermissions', User::class);

        $permissions = $request->input('permissions', []);
        $role->permissions()->sync($permissions);

        return response()->json(['message' => 'Permissions updated successfully']);
    }
}
