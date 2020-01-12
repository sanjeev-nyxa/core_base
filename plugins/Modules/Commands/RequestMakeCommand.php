<?php

namespace Labs\Modules\Commands;

use Illuminate\Support\Str;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RequestMakeCommand
 * @package Labs\Modules\Commands
 */
class RequestMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class for the specified module.';

    /**
     * @return string
     */
    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.generator.request.path', 'Http/Requests');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the form request class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['fields', 'f', InputOption::VALUE_OPTIONAL, 'Generate Request Validation Fields', null],
            ['permission', 'p', InputOption::VALUE_OPTIONAL, 'Generate Request Permission', null],
            ['admin', 'a', InputOption::VALUE_OPTIONAL, 'Generate Admin Request', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $permission = $this->option('permission');
        return (new Stub('/request.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
            'PERMISSION' => $permission ? "\$this->user()->can('$permission')" : 'true',
            'PERMISSION_DESCRIPTION' => $permission ? "permission:'$permission'" : 'null',
            'FIELDS' => $this->option('fields') ? $this->getFields() : '//',
            'API' => $this->option('admin') ? 'Admin' : 'API',
            'MODULE' => $this->getModuleName()
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $requestPath = GenerateConfigReader::read('request');

        return $path . $requestPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }

    /**
     * @return string
     */
    private function getFields()
    {
        $content = "";
        foreach (explode(',', $this->option('fields')) as $field) {
            $field = explode(':', trim($field));
            $content .= "'$field[0]' => ['required', '$field[1]'],\n            ";
        }
        return $content;
    }
}
