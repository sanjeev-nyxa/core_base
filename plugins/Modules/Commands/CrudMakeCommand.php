<?php

namespace Labs\Modules\Commands;

use Illuminate\Support\Str;
use Labs\Modules\Support\Code;
use Labs\Modules\Support\Config\GenerateConfigReader;
use Labs\Modules\Support\Stub;
use Labs\Modules\Support\Vue;
use Labs\Modules\Traits\ModuleCommandTrait;
use Spatie\TranslationLoader\LanguageLine;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CrudMakeCommand
 * @package Labs\Modules\Commands
 */
class CrudMakeCommand extends GeneratorCommand
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
    protected $name = 'module:make-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Crud for the specified module.';

    /**
     * @var array
     */
    protected $crudStatus = [
        'model' => false,
        'migration' => false,
        'resource' => false,
        'requests' => false,
        'controller' => false,
        'router' => false,
    ];

    /**
     * @var array
     */
    protected $crud = [
        'fields' => [],
        'fillable' => []
    ];


    /**
     *
     */
    public function handle()
    {
        $name = $this->getModelName();
        $module = $this->getModuleName();

        // 1. Entities, 2. Migration
        $this->generateModelAndMigration($name, $module);

        // 3. Resource
        $this->generateResource($name, $module);

        // 4. Requests
        $this->generateRequests($name, $module);

        // 5. Controller
        $this->generateController($name, $module);

        // 6. Routes
        $this->generateRouter($name, $module);

        // 7. Events

        // 8. Vue CRUD Components + Router
        $this->generateVueComponents($name, $module);

        // 9. Permissions
        $this->generatePermissions($name, $module);

        // 10. Translations
        $this->generateTranslations($name, $module);

        // 11. Test

        dd($this->crudStatus, $this->crud);
    }

    /**
     * Create a proper migration name:
     * ProductDetail: product_details
     * Product: products
     * @return string
     */
    private function createMigrationName()
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->argument('model'), -1, PREG_SPLIT_NO_EMPTY);

        $string = '';
        foreach ($pieces as $i => $piece) {
            if ($i + 1 < count($pieces)) {
                $string .= strtolower($piece) . '_';
            } else {
                $string .= Str::plural(strtolower($piece));
            }
        }

        return $string;
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The name of model will be created.'],
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
            ['fillable', null, InputOption::VALUE_OPTIONAL, 'The fillable attributes.', null],
            ['migration', 'm', InputOption::VALUE_NONE, 'Flag to create associated migrations', null],
        ];
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
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly($this->argument('model'));
    }

    /**
     * @return string
     */
    private function getFillable()
    {
        $fillable = $this->option('fillable');

        if (!is_null($fillable)) {
            $arrays = explode(',', $fillable);

            return json_encode($arrays);
        }

        return '[]';
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
     * @param $name
     * @param $module
     */
    protected function generateModelAndMigration($name, $module): void
    {
        if ($this->confirm('Do you want to generate Model', true)) {
            $this->crudStatus['model'] = true;
            $fillable = $this->ask('Please Specify Your fillable fields (ex: title, description)');
            $this->crud['fillable'] = explode(',', trim($fillable));
            $this->call("module:make-model", [
                'model' => $name,
                'module' => $module,
                '--fillable' => $fillable
            ]);
        }

        if ($this->confirm('Do you want to generate migration', true)) {
            $this->crudStatus['migration'] = true;
            $fields = $this->ask('Please Specify Your fields (ex: title:string, description:string, content:text)');
            $this->crud['fields'] = explode(',', trim($fields));
            $migrationName = 'create_' . $this->createMigrationName() . '_table';
            $this->call('module:make-migration', [
                'name' => $migrationName,
                'module' => $module,
                '--fields' => $fields
            ]);
        }
    }

    /**
     * @param $name
     * @param $module
     */
    protected function generateResource($name, $module): void
    {
        if ($this->confirm('Do you want to generate Resource', true)) {
            $this->crudStatus['resource'] = true;
            $this->call("module:make-resource", [
                'name' => 'Admin/' . $name . 'Resource',
                'module' => $module,
            ]);
            $this->call("module:make-resource", [
                'name' => 'API/' . $name . 'Resource',
                'module' => $module,
            ]);
        }
    }

    /**
     * @param $name
     * @param $module
     */
    protected function generateRequests($name, $module): void
    {
        if ($this->confirm('Do you want to generate Requests', true)) {
            $this->crudStatus['requests'] = true;
            // Generate For Admin
            $this->call("module:make-request", [
                'name' => 'Admin/' . $name . '/' . $name . 'ShowRequest',
                'module' => $module,
                '--admin' => 'Admin'
            ]);
            $this->call("module:make-request", [
                'name' => 'Admin/' . $name . '/' . $name . 'StoreRequest',
                'module' => $module,
                '--fields' => implode(',', $this->crud['fields']),
                '--permission' => 'create_'.str_plural(strtolower($name)),
                '--admin' => 'Admin'
            ]);
            $this->call("module:make-request", [
                'name' => 'Admin/' . $name . '/' . $name . 'UpdateRequest',
                'module' => $module,
                '--fields' => implode(',', $this->crud['fields']),
                '--permission' => 'update_'.str_plural(strtolower($name)),
                '--admin' => 'Admin'
            ]);
            $this->call("module:make-request", [
                'name' => 'Admin/' . $name . '/' . $name . 'DestroyRequest',
                'module' => $module,
                '--admin' => 'Admin'
            ]);

            // Generate For API
            $this->call("module:make-request", [
                'name' => 'API/' . $name . '/' . $name . 'ShowRequest',
                'module' => $module,
            ]);
//            $this->call("module:make-request", [
//                'name' => 'API/' . $name . '/' . $name . 'StoreRequest',
//                'module' => $module,
//            ]);
//            $this->call("module:make-request", [
//                'name' => 'API/' . $name . '/' . $name . 'UpdateRequest',
//                'module' => $module,
//            ]);
//            $this->call("module:make-request", [
//                'name' => 'API/' . $name . '/' . $name . 'DestroyRequest',
//                'module' => $module,
//            ]);
        }
    }

    /**
     * @param $name
     * @param $module
     */
    protected function generateController($name, $module): void
    {
        if ($this->confirm('Do you want to generate Controller', true)) {
            $this->crudStatus['controller'] = true;
            $this->call("module:make-controller", [
                'controller' => 'Admin/' . $name,
                'module' => $module,
                '--model' => $name,
                '--api' => 'Admin'
            ]);
            $this->call("module:make-controller", [
                'controller' => 'API//' . $name,
                'module' => $module,
                '--model' => $name,
                '--api' => 'API'
            ]);
        }
    }

    /**
     * @param $name
     * @param $module
     */
    protected function generateRouter($name, $module): void
    {
        if ($this->confirm('Do you want to generate Router', true)) {
            $this->crudStatus['router'] = true;
            $this->call("module:make-router", [
                'name' => $name,
                'module' => $module,
            ]);
        }
    }

    /**
     * @param $name
     * @param $module
     */
    private function generateVueComponents($name, $module)
    {
        if ($this->confirm('Do you want to generate Vue Form', true)) {
            $this->crudStatus['vue_form'] = true;
            $this->call("vue:make-form", [
                'name' => $name,
                'module' => $module,
                '--fields' => implode(',', $this->crud['fields'])
            ]);
        }

        if ($this->confirm('Do you want to generate Vue Table', true)) {
            $this->crudStatus['vue_table'] = true;
            $this->call("vue:make-table", [
                'name' => $name,
                'module' => $module,
                '--headers' => implode(',', $this->crud['fillable'])
            ]);
        }

        if ($this->crudStatus['vue_table'] && $this->crudStatus['vue_form']) {
            $this->call("vue:make-route", [
                'name' => $name,
                'module' => $module,
            ]);

            $vue = new Vue($module);
            $vue->updateRoutesFile(strtolower(str_plural($name)));
        }
    }

    /**
     * @param $name
     * @param $module
     */
    private function generatePermissions($name, $module)
    {
        if ($this->confirm('Do you want to generate model permissions', true)) {
            $code = new Code($module);
            $code->addNewPermissionToListener(str_plural(strtolower($name)));
        }
    }

    /**
     * @param $name
     * @param $module
     */
    private function generateTranslations($name, $module)
    {
        if ($this->confirm('Do you want to generate model translations', true)) {
            LanguageLine::create([
                'group' => 'admin',
                'key' => str_plural(strtolower($name)) . '.index',
                'text' => [
                    'en' => $name
                ]
            ]);

            LanguageLine::create([
                'group' => 'admin',
                'key' => str_plural(strtolower($name)) . '.create',
                'text' => [
                    'en' => "Add"
                ]
            ]);

            LanguageLine::create([
                'group' => 'admin',
                'key' => str_plural(strtolower($name)) . '.edit',
                'text' => [
                    'en' => "Edit"
                ]
            ]);

        }
    }
}
