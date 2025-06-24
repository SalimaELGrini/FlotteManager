<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // 
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //  
        $permissions = [
            'view drivers', 'create drivers', 'edit drivers', 'delete drivers',
            'view vehicules', 'create vehicules', 'edit vehicules', 'delete vehicules',
            'view assignments', 'create assignments', 'edit assignments', 'delete assignments',
            'view garages', 'create garages', 'edit garages', 'delete garages',
            'view pannes', 'create pannes', 'edit pannes', 'delete pannes',
            'view interventions', 'create interventions', 'edit interventions', 'delete interventions',
            'view fuel', 'create fuel', 'edit fuel', 'delete fuel',
            'view pieces', 'create pieces', 'edit pieces', 'delete pieces',
            'manage settings',
        ];

        // 
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // 
        $admin = Role::firstOrCreate(['name' => 'admin']); //  Superadmin
        $user = Role::firstOrCreate(['name' => 'user']);   //  Admin 

        //     Admin
        $admin->syncPermissions(Permission::all());

        //     
        $user->syncPermissions([
            'view drivers', 'create drivers', 'edit drivers',
            'view vehicules', 'create vehicules', 'edit vehicules',
            'view assignments', 'create assignments', 'edit assignments',
            'view garages', 'create garages', 'edit garages',
            'view pannes', 'create pannes', 'edit pannes',
            'view interventions', 'create interventions', 'edit interventions',
            'view fuel', 'create fuel', 'edit fuel',
            'view pieces', 'create pieces', 'edit pieces',
        ]);
    }
}

    

