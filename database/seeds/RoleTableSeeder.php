<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();

        $role = new Role;
        $roleAdmin = $role->create([
            'name'        => 'Administrator',
            'slug'        => 'administrator',
            'description' => 'Manage administration privileges.',
        ]);

        $role = new Role;
        $roleDeveloper = $role->create([
            'name'        => 'Developer',
            'slug'        => 'developer',
            'description' => 'Manage developer privileges.',
        ]);

        $role = new Role;
        $roleModerator = $role->create([
            'name'        => 'Moderator',
            'slug'        => 'moderator',
            'description' => 'Manage moderator privileges.',
        ]);

        $role = new Role;
        $roleProductOwner = $role->create([
            'name'        => 'Product Owner',
            'slug'        => 'p-o',
            'description' => 'Manage product owner privileges.'
        ]);
    }
}
