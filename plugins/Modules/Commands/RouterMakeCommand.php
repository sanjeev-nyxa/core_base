<?php

namespace Labs\Modules\Commands;

use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class RouterMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-router';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new router crud for the specified module';

    public function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/router.stub', [
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
            'STUDLY_NAME' => $this->getFileName(),
            'MODULE_NAME' => $this->getModuleName(),
            'PREFIX' => strtolower($this->getFileName()),
            'PREFIX_PLURAL' => strtolower(str_plural($this->getFileName()))
        ]))->render();
    }

    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $routerPath = GenerateConfigReader::read('router');

        return $path . $routerPath->getPath() . '/' . strtolower(str_plural($this->getFileName())) . '.php';
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        return studly_case($this->argument('name'));
    }

    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.generator.router.path', 'Router');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the event.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }
}
