<?php

namespace Labs\Modules\Commands;

use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'controller';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful controller for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('controller');

        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $arr = explode("/", $this->getControllerName());
        $controller = end($arr);

        return (new Stub($this->getStubName(), [
            'MODULENAME' => $module->getStudlyName(),
            'CONTROLLERNAME' => $controller,
            'NAMESPACE' => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $controller,
            'LOWER_NAME' => $module->getLowerName(),
            'MODULE' => $this->getModuleName(),
            'MODEL' => studly_case($this->option('model')),
            'MODEL_LOWER_NAME' => strtolower($this->option('model')),
            'MODEL_PLURAL_LOWER_NAME' => str_plural(strtolower($this->option('model'))),
            'MODEL_PLURAL_NAME' => $this->option('model') ? str_plural($this->option('model')) : '',
            'API' => $this->option('api'),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['controller', InputArgument::REQUIRED, 'The name of the controller class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain controller', null],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Specify The CRUD Mode', null],
            ['api', 'a', InputOption::VALUE_OPTIONAL, 'Specify The API Path'],
        ];
    }

    /**
     * @return array|string
     */
    protected function getControllerName()
    {
        $controller = studly_case($this->argument('controller'));

        if (str_contains(strtolower($controller), 'controller') === false) {
            $controller .= 'Controller';
        }

        return $controller;
    }

    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.generator.controller.path', 'Http/Controllers');
    }

    /**
     * Get the stub file name based on the plain option
     * @return string
     */
    private function getStubName()
    {
        if ($this->option('api') === 'API') {
            return '/controller-api.stub';
        }

        if ($this->option('api') === 'Admin') {
            return '/controller-admin.stub';
        }


        if ($this->option('plain') === true) {
            return '/controller-plain.stub';
        }

        return '/controller.stub';
    }
}
