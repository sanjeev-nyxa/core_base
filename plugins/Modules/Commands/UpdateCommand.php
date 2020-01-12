<?php

namespace Labs\Modules\Commands;

use Illuminate\Console\Command;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class UpdateCommand
 * @package Labs\Modules\Commands
 */
class UpdateCommand extends Command
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dependencies for the specified module or for all modules.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('module');

        if ($name) {
            $this->updateModule($name);

            return;
        }

        /** @var \Labs\Modules\Module $module */
        foreach ($this->laravel['modules']->getOrdered() as $module) {
            $this->updateModule($module->getName());
        }

        $this->call('db:seed', [
            '--class' => 'Labs\Core\Database\Seeders\PermissionTableSeeder'
        ]);

        $this->call('db:seed', [
            '--class' => 'Labs\Core\Database\Seeders\TranslationTableSeeder'
        ]);
    }

    /**
     * @param $name
     */
    protected function updateModule($name)
    {
        $this->line('Running for module: <info>' . $name . '</info>');

        $this->laravel['modules']->update($name);

        $this->call('module:migrate', [
            'module' => $name
        ]);

        $this->info("Module [{$name}] updated successfully.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of module will be updated.'],
        ];
    }
}
