<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'librarian',
            'user',
        ];
        $admin_permissions = [
            'insert-user',
            'show-user',
            'update-user',
            'delete-user',
            'insert-book-category',
            'show-book-category',
            'update-book-category',
            'delete-book-category',
            'insert-book',
            'show-book',
            'update-book',
            'delete-book',
        ];
        $librarian_permissions = [
            'insert-book-category',
            'show-book-category',
            'update-book-category',
            'delete-book-category',
            'insert-book',
            'show-book',
            'update-book',
            'delete-book',
        ];

        $guard_name = 'web';
        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role,
                'guard_name' => $guard_name,
            ]);
            if ($role->name == 'admin') {
                $role->syncPermissions($admin_permissions);
            }
            if ($role->name == 'librarian') {
                $role->syncPermissions($librarian_permissions);
            }
        }
    }
}