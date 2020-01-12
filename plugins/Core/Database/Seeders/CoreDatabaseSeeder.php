<?php

namespace Labs\Core\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Class CoreDatabaseSeeder
 * @package Labs\Core\Database\Seeders
 */
class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        $this->call(TranslationTableSeeder::class);
    }
}
