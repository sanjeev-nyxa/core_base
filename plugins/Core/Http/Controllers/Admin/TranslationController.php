<?php

namespace Labs\Core\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;
use Labs\Core\Http\Requests\Admin\Translation\TranslationDestroyRequest;
use Labs\Core\Http\Requests\Admin\Translation\TranslationShowRequest;
use Labs\Core\Http\Requests\Admin\Translation\TranslationStoreRequest;
use Labs\Core\Http\Requests\Admin\Translation\TranslationUpdateRequest;
use Labs\Core\Http\Resources\Admin\TranslationResource;
use Labs\Core\Entities\Export\TranslationsExporter;
use Labs\Core\Entities\Import\TranslationImporter;

/**
 * Class TranslationController
 * @package Zix\Core\Http\Controllers\Admin
 * @resource Admin Language
 */
class TranslationController
{
    /**
     * @var LanguageLine
     */
    private $model;


    /**
     * TranslationController constructor.
     * @param LanguageLine $model
     */
    public function __construct(LanguageLine $model)
    {
        $this->model = $model;
    }

    /**
     * @param TranslationShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TranslationShowRequest $request)
    {
        return datatables()->eloquent($this->model->query())->toJson();
    }

    /**
     * @param TranslationShowRequest $request
     * @param LanguageLine $translate
     * @return TranslationResource
     */
    public function show(TranslationShowRequest $request, LanguageLine $translate)
    {
        return new TranslationResource($translate);
    }

    /**
     * @param TranslationStoreRequest $request
     * @return TranslationResource
     */
    public function store(TranslationStoreRequest $request)
    {
        return new TranslationResource($this->model->create($request->input()));
    }

    /**
     * @param TranslationUpdateRequest $request
     * @param LanguageLine $translate
     * @return TranslationResource
     */
    public function update(TranslationUpdateRequest $request, LanguageLine $translate)
    {
        $translate->update($request->input());
        return new TranslationResource($translate);
    }

    /**
     * @param TranslationDestroyRequest $request
     * @param LanguageLine $translate
     * @return TranslationResource
     * @throws \Exception
     */
    public function destroy(TranslationDestroyRequest $request, LanguageLine $translate)
    {
        $translate->delete();
        return new TranslationResource($translate);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function export(Request $request)
    {
        if ($request->get('token') && User::find($request->get('token'))->can('view_translations')) {
            return \Excel::download(new TranslationsExporter($this->model->all()), 'translations_' . Carbon::now()->format('d-m-Y') . '.csv');
        }
        return "You don't have access for this area";
    }


    /**
     * Import Data
     * @param TranslationUpdateRequest $request
     * @return array
     */
    public function import(TranslationUpdateRequest $request)
    {
        $importer = (new TranslationImporter())->setCsvFile($request->file('file'));
        $importer->run();

        return $importer->finish();
    }
}