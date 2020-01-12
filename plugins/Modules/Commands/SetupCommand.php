<?php

namespace Labs\Modules\Commands;

use Illuminate\Support\Str;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;

/**
 * Class CrudMakeCommand
 * @package Labs\Modules\Commands
 */
class SetupCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'model';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup The LV-Core';


    public function handle()
    {
        $this->call('down');

        $this->call('key:generate');

        $this->call('module:migrate');
        $this->call('module:seed');

        $this->call('passport:install');
        $this->call('storage:link');
        $this->call('cache:clear');


        $this->call('up');
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }


    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly($this->argument('model'));
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.generator.model.path', 'Entities');
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $modelPath = GenerateConfigReader::read('model');

        return $path . $modelPath->getPath() . '/' . $this->getModelName() . '.php';
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/model.stub', [
            'NAME' => $this->getModelName(),
            'FILLABLE' => $this->getFillable(),
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
            'LOWER_NAME' => $module->getLowerName(),
            'MODULE' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }
}
