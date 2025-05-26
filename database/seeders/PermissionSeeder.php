<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
            'user-management',
            'import-data',
            'import-orders',
            'import-customers',
            'import-invoices',
        ];

        foreach($permissions as $perm) {
            Permission::findOrCreate($perm);
        }

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions($permissions);

        $importer = Role::findOrCreate('importer');
        $importer->syncPermissions([
            'import-data',
            'import-orders',
            'import-customers',
            'import-invoices',
        ]);
    }
}
