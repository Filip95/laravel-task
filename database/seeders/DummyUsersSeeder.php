<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create()
            ->assignRole('admin');

        User::factory()
            ->importer()
            ->create()
            ->assignRole('importer');

        $roles = Role::pluck('name')->all();

        User::factory()
            ->count(8)
            ->create()
            ->each(function(User $user) use ($roles) {
                $user->assignRole($roles[array_rand($roles)]);
            });
    }
}
