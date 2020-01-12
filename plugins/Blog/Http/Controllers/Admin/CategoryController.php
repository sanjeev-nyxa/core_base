<?php

namespace Labs\Blog\Http\Controllers\Admin;

use Labs\Blog\Entities;
use Labs\Blog\Http\Requests\Admin\Category as CategoryRequests;
use Labs\Blog\Http\Resource\Admin\CategoryResource;
use Labs\Core\Http\Controllers\Controller;

/**
 * Class CategoryController
 * @property Entities\Category model
 * @package Zix\PluginName\Http\Controllers/Admin
 */
class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     * @param Entities\Category $model
     */
    public function __construct(Entities\Category $model)
    {
        $this->model = $model;
    }

    /**
     * @param CategoryRequests\CategoryShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CategoryRequests\CategoryShowRequest $request)
    {
        return datatables()->eloquent($this->model->with('blogs'))->toJson();
    }

    /**
     * @param CategoryRequests\CategoryShowRequest $request
     * @param Entities\Category $category
     * @return CategoryResource
     */
    public function show(CategoryRequests\CategoryShowRequest $request, Entities\Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequests\CategoryStoreRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequests\CategoryStoreRequest $request)
    {
        $model = $this->model->create($request->input());
        return new CategoryResource($model);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Entities\Category $category
     * @param  CategoryRequests\CategoryUpdateRequest $request
     * @return CategoryResource
     */
    public function update(CategoryRequests\CategoryUpdateRequest $request, Entities\Category $category)
    {
        $category->update($request->input());
        return new CategoryResource($category);
    }

    /**
     * @param CategoryRequests\CategoryDestroyRequest $request
     * @param Entities\Category $category
     * @return CategoryResource
     */
    public function destroy(CategoryRequests\CategoryDestroyRequest $request, Entities\Category $category)
    {
        $category->delete();

        return new CategoryResource($category);
    }
}
