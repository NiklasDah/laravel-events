<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::factory()->create(['name' => 'admin']);
        Role::factory()->create(['name' => 'organizer']);
        // Add further roles.
    }
}
