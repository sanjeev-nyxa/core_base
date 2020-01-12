<?php

namespace Labs\Modules\Commands\Vue;

use Illuminate\Support\Str;
use Labs\Modules\Commands\GeneratorCommand;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class VueTableMakeCommand extends GeneratorCommand
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
    protected $name = 'vue:make-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Vue Table for the specified module.';

    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.vue_table.command.path', 'VueTable');
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
            ['headers', null, InputOption::VALUE_OPTIONAL, 'The table headers that should be assigned.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());


        return (new Stub('/vue/table.stub', [
            'MODEL' => strtolower($this->getFileName()),
            'MODEL_NAME' => $this->getModelName().'Table',
            'MODEL_LOWER_NAME' => strtolower($this->getModelName()),
            'TABLE_HEADERS' => $this->getHeaders(),
        ]))->render();
    }


    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $commandPath = GenerateConfigReader::read('vue_table');

        return $path . $commandPath->getPath() . '/+' . strtolower($this->getModelName()) . '/' . $this->getModelName() . 'Table.js';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }

    private function getHeaders()
    {
        $headers = explode(',', $this->option('headers') ?: 'name:sortable:searchable,title,description');

        $content = "";
        foreach ($headers as $header) {
            $h = explode(':', trim($header));
            $title = lcfirst($h[0]);
            $content .= "{
                            text: '$title',
                            value: '$h[0]',
                            align: '" . (in_array('right', $h) ? 'right' : 'left') . "',
                            searchable: " . (in_array('searchable', $h) ? 'true' : 'false') . ",
                            sortable: " . (in_array('sortable', $h) ? 'true' : 'false') . ",
                        },
                        ";
        }
        return $content;
    }

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return str_plural($this->getFileName());
    }

}
