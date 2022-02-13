<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $adminRole = Role::create(['name' => 'SUPER ADMIN']);
        $clientRole = Role::create(['name' => 'role.client']);
        $promoterRole = Role::create(['name' => 'role.promoter']);

        // LOGINS
        $loginPermissions = [];
        $loginPermissions[] = Permission::create(['name' => 'admin.access']);
        $loginPermissions[] = Permission::create(['name' => 'app.access']);

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

        $user = User::create([
            'name' => 'Carlos Esau Gonzalez Soto',
            'email' => 'esau.egs1@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$UGUqS1adZtIN5SJbRvhKY.wo3tJwUBxdv9yIaW4EIuPqGmVepLA9m', // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($adminRole->name);
    }
}
