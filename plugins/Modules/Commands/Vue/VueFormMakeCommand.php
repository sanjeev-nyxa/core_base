<?php

namespace Labs\Modules\Commands\Vue;

use Illuminate\Support\Str;
use Labs\Modules\Commands\GeneratorCommand;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class VueFormMakeCommand extends GeneratorCommand
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
    protected $name = 'vue:make-form';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Vue Form for the specified module.';

    public function getDefaultNamespace(): string
    {
        return $this->laravel['modules']->config('paths.vue_form.command.path', 'VueForm');
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
            ['fields', null, InputOption::VALUE_OPTIONAL, 'The form fields that should be assigned.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());


        return (new Stub('/vue/form.stub', [
            'MODEL' => strtolower($this->getFileName()),
            'MODEL_NAME' => $this->getModelName() . 'Form',
            'MODEL_LOWER_NAME' => strtolower($this->getModelName()),
            'FORM_FIELDS' => $this->getFormFields()
        ]))->render();
    }


    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $commandPath = GenerateConfigReader::read('vue_form');

        return $path . $commandPath->getPath() . '/+' . strtolower($this->getModelName()) . '/' . $this->getModelName() . 'Form.vue';
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

    private function getFormFields()
    {
        $fields = explode(',', $this->option('fields') ?: 'title:string,description:text,status:boolean');
        $content = "";
        $model = strtolower($this->getFileName());

        foreach ($fields as $field) {
            $f = explode(':', trim($field));

            if (in_array('string', $f) || in_array('integer', $f) || in_array('float', $f)) {
                $content .= $this->getStringField($f, $model);
            } else if (in_array('text', $f)) {
                $content .= $this->getTextField($f, $model);
            } else if (in_array('boolean', $f)) {
                $content .= $this->getBooleanField($f, $model);
            }

        }

        return $content;
    }

    /**
     * @param $f
     * @param $model
     * @return string
     */
    private function getStringField($f, $model): string
    {
        $title = lcfirst($f[0]);
        return "
                <v-text-field
                        name=\"$f[0]\"
                        label=\"$title\"
                        v-model=\"$model.$f[0]\"
                        :rules=\"messages.validation.$f[0]\"
                        required
                ></v-text-field>
            ";
    }

    /**
     * @param $f
     * @param $model
     * @return string
     */
    private function getTextField($f, $model): string
    {
        $title = lcfirst($f[0]);
        return "
                <v-text-field
                        name=\"$f[0]\"
                        label=\"$title\"
                        v-model=\"$model.$f[0]\"
                        :rules=\"messages.validation.$f[0]\"
                        textarea
                        required
                ></v-text-field>
            ";
    }

    /**
     * @param $f
     * @param $model
     * @return string
     */
    private function getBooleanField($f, $model): string
    {
        $title = lcfirst($f[0]);
        return "
                <v-checkbox
                        name=\"$f[0]\"
                        label=\"$title\"
                        v-model=\"$model.$f[0]\"
                ></v-checkbox>
            ";
    }

}
