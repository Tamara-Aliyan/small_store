<?php

namespace App\Policies;

use App\Enums\DefinePermissions;
use Illuminate\Auth\Access\Response;
use App\Models\API\V1\{User,Category};

class CategoryPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::CATEGORY_Index);
    }

    public function view(User $user, Category $category): bool
    {
        return $user->hasPermission(DefinePermissions::CATEGORY_READ);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::CATEGORY_CREATE);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasPermission(DefinePermissions::CATEGORY_UPDATE);
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasPermission(DefinePermissions::CATEGORY_DELETE);
    }

}
