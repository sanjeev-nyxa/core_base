<?php namespace Labs\Core\Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 * @package Labs\Core\Database\Seeds
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminAccount()->assignRole('Admin');
        $this->createProviderAccount()->assignRole('Provider');
    }

    /**
     * @return User
     */
    protected function createProviderAccount(): User
    {
        return User::create([
            'user_id' => $this->getUserId(),
            'first_name' => 'Provider',
            'last_name' => 'webnyxa',
            'email' => 'provider@webnyxa.com',
            'password' => bcrypt('welcome')
        ]);
    }

    /**
     * @return User
     */
    protected function createAdminAccount(): User
    {
        return User::create([
            'user_id' => $this->getUserId(),
            'first_name' => 'Admin',
            'last_name' => 'webnyxa',
            'email' => 'admin@webnyxa.com',
            'bio' => 'Some Bio About me',
            'password' => bcrypt('welcome')
        ]);
    }

    /**
     * @return string
     */
    protected function getUserId(): string
    {
        if (User::all()->count()) {
            $latest_id = (int)User::orderByDesc('user_id')->first()->user_id;
        } else {
            $latest_id = 0;
        }
        return str_pad(($latest_id + 1), 4, "0", STR_PAD_LEFT);
    }
}
