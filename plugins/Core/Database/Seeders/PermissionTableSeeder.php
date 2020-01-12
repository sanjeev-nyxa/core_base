<?php namespace Labs\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Labs\Core\Events\Seeder\GetAppPermissions;
use Labs\Core\Entities\Permission;
use Labs\Core\Entities\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect();
        $actions = collect(['view', 'create', 'update', 'delete']);

        event(new GetAppPermissions($permissions));

        $this->createPermissions($permissions, $actions);
    }

    /**
     * @param $permissions
     * @param $actions
     */
    private function createPermissions($permissions, $actions)
    {
        $role = Role::query()->where('name', 'Admin')->first();
        $permissions->map(function ($permission) use ($actions, $role) {
            $actions->map(function ($action) use ($role, $permission) {
                $per = Permission::firstOrCreate([
                    'name' => $action . '_' . $permission,
                    'guard_name' => 'api'
                ]);
                if ($role && !$role->hasPermissionTo($per->name)) {
                    $role->givePermissionTo($per->name);
                }
            });
        });
    }
}
