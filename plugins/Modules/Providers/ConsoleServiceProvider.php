<?php

namespace Labs\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Labs\Modules\Commands\CommandMakeCommand;
use Labs\Modules\Commands\ControllerMakeCommand;
use Labs\Modules\Commands\CrudMakeCommand;
use Labs\Modules\Commands\DisableCommand;
use Labs\Modules\Commands\DumpCommand;
use Labs\Modules\Commands\EnableCommand;
use Labs\Modules\Commands\EventMakeCommand;
use Labs\Modules\Commands\FactoryMakeCommand;
use Labs\Modules\Commands\InstallCommand;
use Labs\Modules\Commands\JobMakeCommand;
use Labs\Modules\Commands\ListCommand;
use Labs\Modules\Commands\ListenerMakeCommand;
use Labs\Modules\Commands\MailMakeCommand;
use Labs\Modules\Commands\MiddlewareMakeCommand;
use Labs\Modules\Commands\MigrateCommand;
use Labs\Modules\Commands\MigrateRefreshCommand;
use Labs\Modules\Commands\MigrateResetCommand;
use Labs\Modules\Commands\MigrateRollbackCommand;
use Labs\Modules\Commands\MigrateStatusCommand;
use Labs\Modules\Commands\MigrationMakeCommand;
use Labs\Modules\Commands\ModelMakeCommand;
use Labs\Modules\Commands\ModuleMakeCommand;
use Labs\Modules\Commands\NotificationMakeCommand;
use Labs\Modules\Commands\PolicyMakeCommand;
use Labs\Modules\Commands\ProviderMakeCommand;
use Labs\Modules\Commands\PublishCommand;
use Labs\Modules\Commands\PublishConfigurationCommand;
use Labs\Modules\Commands\PublishMigrationCommand;
use Labs\Modules\Commands\PublishTranslationCommand;
use Labs\Modules\Commands\RequestMakeCommand;
use Labs\Modules\Commands\ResourceMakeCommand;
use Labs\Modules\Commands\RouteProviderMakeCommand;
use Labs\Modules\Commands\RouterMakeCommand;
use Labs\Modules\Commands\RuleMakeCommand;
use Labs\Modules\Commands\SeedCommand;
use Labs\Modules\Commands\SeedMakeCommand;
use Labs\Modules\Commands\SetupCommand;
use Labs\Modules\Commands\TestMakeCommand;
use Labs\Modules\Commands\UnUseCommand;
use Labs\Modules\Commands\UpdateCommand;
use Labs\Modules\Commands\UseCommand;
use Labs\Modules\Commands\Vue\VueFormMakeCommand;
use Labs\Modules\Commands\Vue\VueRouteMakeCommand;
use Labs\Modules\Commands\Vue\VueTableMakeCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        CrudMakeCommand::class,
        RouterMakeCommand::class,
        SetupCommand::class,


        // Vue Js
        VueTableMakeCommand::class,
        VueFormMakeCommand::class,
        VueRouteMakeCommand::class
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
