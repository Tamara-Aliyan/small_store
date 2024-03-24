<?php

namespace App\Policies;

use App\Enums\DefinePermissions;
use Illuminate\Auth\Access\Response;
use App\Models\API\V1\{User,Product};

class ProductPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::PRODUCT_Index);
    }

    public function view(User $user, Product $product): bool
    {
        return $user->hasPermission(DefinePermissions::PRODUCT_READ);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(DefinePermissions::PRODUCT_CREATE);
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasPermission(DefinePermissions::PRODUCT_UPDATE);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasPermission(DefinePermissions::PRODUCT_DELETE);
    }
}
