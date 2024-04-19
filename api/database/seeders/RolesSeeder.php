<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $student = Role::create(['name' => 'student']);
        $universityStaff = Role::create(['name' => 'university staff']);
        $ministryStaff = Role::create(['name' => 'ministry staff']);
        $conferenceCreator = Role::create(['name' => 'conference creator']);

        $crudArt[] = Permission::create(['name'=>'create articles']);
        $crudArt[] = Permission::create(['name'=>'update articles']);
        $crudArt[] = Permission::create(['name'=>'delete articles']);
        $analytics = Permission::create(['name'=>'analytics']);
        $advancedAnalytics = Permission::create(['name'=>'advanced analytics']);
        $conferenceCrud[] = Permission::create(['name'=>'index conference']);
        $conferenceCrud[] = Permission::create(['name'=>'create conference']);
        $conferenceCrud[] = Permission::create(['name'=>'update conference']);
        $conferenceCrud[] = Permission::create(['name'=>'delete conference']);
        $conferenceCrud[] = Permission::create(['name'=>'add article']);
        $conferenceCrud[] = Permission::create(['name'=>'add org committee']);
        $conferenceCrud[] = Permission::create(['name'=>'remove org committee']);
        $conferenceCrud[] = Permission::create(['name'=>'add editor']);
        $conferenceCrud[] = Permission::create(['name'=>'remove editor']);
        $student->givePermissionTo($crudArt);
        $ministryStaff->givePermissionTo($analytics);
        $ministryStaff->givePermissionTo($advancedAnalytics);
        $conferenceCreator->givePermissionTo($conferenceCrud);
        $conferenceCreator->givePermissionTo($crudArt);

        Role::create(['name' => 'superadmin']);
    }
}
