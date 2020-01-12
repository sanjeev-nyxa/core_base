<?php

namespace Labs\Modules\Commands\Vue;

use Illuminate\Support\Str;
use Labs\Modules\Commands\GeneratorCommand;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class VueRouteMakeCommand extends GeneratorCommand
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
    protected $name = 'vue:make-route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Vue Route for the specified module.';

    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.vue_route.command.path', 'VueRoute');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the command.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
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
//            ['headers', null, InputOption::VALUE_OPTIONAL, 'The table headers that should be assigned.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        return (new Stub('/vue/route.stub', [
            'MODEL' => strtolower($this->getFileName()),
            'MODEL_NAME' => $this->getModelName(),
            'MODEL_LOWER_NAME' => strtolower($this->getModelName()),
        ]))->render();
    }


    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $commandPath = GenerateConfigReader::read('vue_route');

        return $path . $commandPath->getPath() . '/+' . strtolower($this->getModelName()) . '/' . 'index.js';
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
    protected function getModelName(): string
    {
        return str_plural($this->getFileName());
    }

}
