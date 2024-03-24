<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\DefinePermissions;
use Illuminate\Support\Facades\Hash;
use App\Models\API\V1\{Role,Permission,User};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        // Seed roles
        $roles = ['Owner', 'Admin', 'Super-admin', 'Supervisor'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Seed permissions
        $permissions = [
            DefinePermissions::PRODUCT_Index,
            DefinePermissions::PRODUCT_CREATE,
            DefinePermissions::PRODUCT_READ,
            DefinePermissions::PRODUCT_UPDATE,
            DefinePermissions::PRODUCT_DELETE,
            DefinePermissions::CATEGORY_Index,
            DefinePermissions::CATEGORY_CREATE,
            DefinePermissions::CATEGORY_READ,
            DefinePermissions::CATEGORY_UPDATE,
            DefinePermissions::CATEGORY_DELETE,
            DefinePermissions::USER_Index,
            DefinePermissions::USER_CREATE,
            DefinePermissions::USER_READ,
            DefinePermissions::USER_UPDATE,
            DefinePermissions::USER_DELETE,
            DefinePermissions::PERMISSION_UPDATE,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to all roles initially
        $allPermissions = Permission::pluck('id');
        Role::all()->each(function ($role) use ($allPermissions) {
            $role->permissions()->sync($allPermissions);
        });

        // Create a user with the role of "Owner"
        $ownerRole = Role::where('name', 'Owner')->first();

        $user = \Database\Factories\UserFactory::new()->create([
            'name' => 'Owner Name',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->roles()->attach($ownerRole);

    }
}
