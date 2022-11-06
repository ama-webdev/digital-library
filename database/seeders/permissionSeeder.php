<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissons = [
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

        $guard_name = 'web';
        foreach ($permissons as $permisson) {
            Permission::create([
                'name' => $permisson,
                'guard_name' => $guard_name,
            ]);
        }
    }
}