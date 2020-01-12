<?php

namespace Labs\Blog\Http\Controllers\API;

use Labs\Core\Http\Controllers\Controller;
use Labs\Blog\Entities;
use Labs\Blog\Http\Resource\API\CategoryResource;
use Labs\Blog\Http\Requests\API\Category as CategoryRequests;

/**
 * Class CategoryController
 * @property Entities\Category model
 * @package Zix\PluginName\Http\Controllers/API
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
         * @SWG\Get(
         *   path="/categories",
         *   tags={"Blog"},
         *   summary="List categories",
         *   operationId="getBlog",
         *   @SWG\Response(response=200, description="successful operation"),
         *   @SWG\Response(response=406, description="not acceptable"),
         *   @SWG\Response(response=500, description="internal server error")
         * )
         * @param CategoryRequests\CategoryShowRequest $request
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function index(CategoryRequests\CategoryShowRequest $request)
        {
            return CategoryResource::collection($this->model->all());
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

}
