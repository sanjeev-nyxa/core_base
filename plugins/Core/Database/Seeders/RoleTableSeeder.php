<?php namespace Labs\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Labs\Core\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Provider']);
    }
}
