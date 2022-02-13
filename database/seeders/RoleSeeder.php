<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'SUPER ADMIN']);
        $clientRole = Role::create(['name' => 'role.client']);
        $promoterRole = Role::create(['name' => 'role.promoter']);

        // LOGINS
        $loginPermissions = [];
        $loginPermissions[] = Permission::create(['name' => 'admin.access']);
        $loginPermissions[] = Permission::create(['name' => 'app.access']);

        $clientRole->givePermissionTo($loginPermissions[0]);

        foreach ($loginPermissions as $key => $permission) {
            $permission->assignRole($adminRole);
        }
        
        // USERS
        $adminUsersPermissions = [];
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.create']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.show']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.edit']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.delete']);

        foreach ($adminUsersPermissions as $key => $permission) {
            $permission->assignRole($adminRole);
        }
        
        // FINANCIAL
        $adminFinancialPermissions = [];
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.create']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.show']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.edit']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.delete']);

        foreach ($adminFinancialPermissions as $key => $permission) {
            $permission->assignRole($adminRole);
        }
    }
}
