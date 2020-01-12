<?php

namespace Labs\Blog\Http\Controllers\API;

use Labs\Core\Http\Controllers\Controller;
use Labs\Blog\Entities;
use Labs\Blog\Http\Resource\API\BlogResource;
use Labs\Blog\Http\Requests\API\Blog as BlogRequests;

/**
 * Class BlogController
 * @property Entities\Blog model
 * @package Zix\PluginName\Http\Controllers/API
 */
class BlogController extends Controller
{
        /**
         * BlogController constructor.
         * @param Entities\Blog $model
         */
        public function __construct(Entities\Blog $model)
        {
            $this->model = $model;
        }

        /**
         * @SWG\Get(
         *   path="/blogs",
         *   tags={"Blog"},
         *   summary="List blogs",
         *   operationId="getBlog",
         *   @SWG\Response(response=200, description="successful operation"),
         *   @SWG\Response(response=406, description="not acceptable"),
         *   @SWG\Response(response=500, description="internal server error")
         * )
         * @param BlogRequests\BlogShowRequest $request
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function index(BlogRequests\BlogShowRequest $request)
        {
            return BlogResource::collection($this->model->all());
        }

        /**
         * @param BlogRequests\BlogShowRequest $request
         * @param Entities\Blog $blog
         * @return BlogResource
         */
        public function show(BlogRequests\BlogShowRequest $request, Entities\Blog $blog)
        {
            return new BlogResource($blog);
        }

}
