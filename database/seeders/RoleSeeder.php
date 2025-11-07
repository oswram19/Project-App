<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//se agregaron roles y permisos
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //se crear los rol admin y user
        $Role1 = Role::create(['name'=>'Admin']);
        $Role2 = Role::create(['name'=>'User']);

        Permission::create(['name'=>'admin.home'])->syncRoles([$Role1,$Role2]);
        Permission::create(['name'=>'admin.dashboard'])->syncRoles([$Role1,$Role2]);

        Permission::create(['name'=>'admin.users.index'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.users.create'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.users.edit'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.users.destroy'])->syncRoles([$Role1, $Role2]);

        Permission::create(['name'=>'admin.categories.index'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.categories.create'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.categories.edit'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.categories.destroy'])->syncRoles([$Role1, $Role2]);


        Permission::create(['name'=>'admin.tags.index'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.tags.create'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.tags.edit'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.tags.destroy'])->syncRoles([$Role1, $Role2]);

        Permission::create(['name'=>'admin.posts.index'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.posts.create'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.posts.edit'])->syncRoles([$Role1, $Role2]);
        Permission::create(['name'=>'admin.posts.destroy'])->syncRoles([$Role1, $Role2]);   
    }
}
