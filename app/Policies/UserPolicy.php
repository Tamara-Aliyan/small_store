<?php

namespace App\Policies;

use App\Models\API\V1\{User,Role};
use App\Enums\DefinePermissions;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::USER_Index);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermission(DefinePermissions::USER_READ);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::USER_CREATE);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermission(DefinePermissions::USER_UPDATE);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermission(DefinePermissions::USER_DELETE);
    }

    public function updatePermissions(User $user): bool
    {
        return $user->hasRole('Owner');
    }

}
