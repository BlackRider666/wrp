<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class OrganizationPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $staff = \Spatie\Permission\Models\Role::findByName('university staff');
        $permissions[] = Permission::create(['name'=>'update organization']);
        $permissions[] = Permission::create(['name'=>'create structural unit']);
        $permissions[] = Permission::create(['name'=>'update structural unit']);
        $permissions[] = Permission::create(['name'=>'delete structural unit']);
        $staff->givePermissionTo($permissions);
    }
}
