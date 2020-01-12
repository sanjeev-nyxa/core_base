<?php namespace Labs\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Labs\Core\Entities\Config;

/**
 * Class ConfigsTableSeeder
 * @package Labs\Core\Database\Seeds
 */
class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAppConfig();
        $this->createMailConfig();
        $this->createThemeConfig();

        $this->createBroadcastingConfigs();

        Cache::forget('app_configs');
    }

    private function createThemeConfig(): void
    {
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.warning',
            ],
            ['value' => config('admin.theme.warning')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.success',
            ],
            ['value' => config('admin.theme.success')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.info',
            ],
            ['value' => config('admin.theme.info')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.error',
            ],
            ['value' => config('admin.theme.error')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.accent',
            ],
            ['value' => config('admin.theme.accent')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.secondary',
            ],
            ['value' => config('admin.theme.secondary')]
        );
        Config::updateOrCreate(
            [
                'group' => 'admin_theme',
                'key' => 'admin.theme.primary',
            ],
            ['value' => config('admin.theme.primary')]
        );
    }

    private function createAppConfig(): void
    {
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.name',
            ],
            ['value' => config('app.name')]
        );
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.url',
            ],
            ['value' => config('app.url')]
        );
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.api_url',
            ],
            ['value' => config('app.api_url')]
        );
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.debug',
            ],
            ['value' => config('app.debug')]
        );

        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.timezone',
            ],
            ['value' => config('app.timezone')]
        );
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.fallback_locale',
            ],
            ['value' => config('app.fallback_locale')]
        );
        Config::updateOrCreate(
            [
                'group' => 'app',
                'key' => 'app.locale',
            ],
            ['value' => config('app.locale')]
        );
    }

    private function createMailConfig(): void
    {
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.driver',
            ],
            ['value' => config('mail.driver')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.host',
            ],
            ['value' => config('mail.host')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.port',
            ],
            ['value' => config('mail.port')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.encryption',
            ],
            ['value' => config('mail.encryption')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.username',
            ],
            ['value' => config('mail.username')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.password',
            ],
            ['value' => config('mail.password')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.from.address',
            ],
            ['value' => config('mail.from.address')]
        );
        Config::updateOrCreate(
            [
                'group' => 'mail',
                'key' => 'mail.from.name',
            ],
            ['value' => config('mail.from.name')]
        );
    }

    private function createBroadcastingConfigs(): void
    {
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.enabled',
            ],
            ['value' => config('broadcasting.enabled')]
        );
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.default',
            ],
            ['value' => config('broadcasting.default')]
        );

        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.pusher.driver',
            ],
            ['value' => config('broadcasting.connections.pusher.driver')]
        );
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.pusher.key',
            ],
            ['value' => config('broadcasting.connections.pusher.key')]
        );
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.pusher.secret',
            ],
            ['value' => config('broadcasting.connections.pusher.secret')]
        );
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.pusher.app_id',
            ],
            ['value' => config('broadcasting.connections.pusher.app_id')]
        );

        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.redis.driver',
            ],
            ['value' => config('broadcasting.connections.redis.driver')]
        );
        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.redis.connection',
            ],
            ['value' => config('broadcasting.connections.redis.connection')]
        );

        Config::updateOrCreate(
            [
                'group' => 'broadcasting',
                'key' => 'broadcasting.connections.log.driver',
            ],
            ['value' => config('broadcasting.connections.log.driver')]
        );
    }


}
