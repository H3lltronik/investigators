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
        $superAdminRole = Role::create(['name' => 'SUPER ADMIN']);
        $adminRole = Role::create(['name' => 'role.admin']);
        $clientRole = Role::create(['name' => 'role.client']);
        $promoterRole = Role::create(['name' => 'role.promoter']);

        // LOGINS
        $loginPermissions = [];
        $loginPermissions[] = Permission::create(['name' => 'admin.access']);
        $loginPermissions[] = Permission::create(['name' => 'app.access']);

        $clientRole->givePermissionTo($loginPermissions[0]);
        $promoterRole->givePermissionTo($loginPermissions[0]);

        foreach ($loginPermissions as $key => $permission) {
            $permission->assignRole($superAdminRole);
            $permission->assignRole($adminRole);
        }
        
        // USERS
        $adminUsersPermissions = [];
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.create']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.show']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.edit']);
        $adminUsersPermissions[] = Permission::create(['name' => 'admin.users.delete']);

        foreach ($adminUsersPermissions as $key => $permission) {
            $permission->assignRole($superAdminRole);
            $permission->assignRole($adminRole);
        }
        
        // FINANCIAL
        $adminFinancialPermissions = [];
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.create']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.show']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.edit']);
        $adminFinancialPermissions[] = Permission::create(['name' => 'admin.financial.delete']);

        foreach ($adminFinancialPermissions as $key => $permission) {
            $permission->assignRole($superAdminRole);
            $permission->assignRole($adminRole);
        }
        
        // REQUESTS
        $adminRequestsPermissions = [];
        $adminRequestsPermissions[] = Permission::create(['name' => 'admin.requests.create']);
        $adminRequestsPermissions[] = Permission::create(['name' => 'admin.requests.show']);
        $adminRequestsPermissions[] = Permission::create(['name' => 'admin.requests.edit']);
        $adminRequestsPermissions[] = Permission::create(['name' => 'admin.requests.delete']);

        $adminRequestsPermissions[0]->assignRole($clientRole);
        $adminRequestsPermissions[1]->assignRole($clientRole);

        foreach ($adminRequestsPermissions as $key => $permission) {
            $permission->assignRole($superAdminRole);
            $permission->assignRole($adminRole);
        }
        
        // REQUESTS
        $adminTasksPermissions = [];
        $adminTasksPermissions[] = Permission::create(['name' => 'admin.tasks.create']);
        $adminTasksPermissions[] = Permission::create(['name' => 'admin.tasks.show']);
        $adminTasksPermissions[] = Permission::create(['name' => 'admin.tasks.edit']);
        $adminTasksPermissions[] = Permission::create(['name' => 'admin.tasks.delete']);

        foreach ($adminTasksPermissions as $key => $permission) {
            $permission->assignRole($superAdminRole);
            $permission->assignRole($adminRole);
        }

        
    }
}
