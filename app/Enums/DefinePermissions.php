<?php
namespace App\Enums;

use Spatie\Enum\Enum;

class DefinePermissions extends Enum
{
    // Permissions for Products
    const PRODUCT_Index = 'product_index';
    const PRODUCT_CREATE = 'product_create';
    const PRODUCT_READ = 'product_read';
    const PRODUCT_UPDATE = 'product_update';
    const PRODUCT_DELETE = 'product_delete';

    // Permissions for Categories
    const CATEGORY_Index = 'category_index';
    const CATEGORY_CREATE = 'category_create';
    const CATEGORY_READ = 'category_read';
    const CATEGORY_UPDATE = 'category_update';
    const CATEGORY_DELETE = 'category_delete';

    // Permissions for Users
    const USER_Index = 'user_index';
    const USER_CREATE = 'user_create';
    const USER_READ = 'user_read';
    const USER_UPDATE = 'user_update';
    const USER_DELETE = 'user_delete';

    // Permission for managing permissions
    const PERMISSION_UPDATE = 'permission_update';
}
