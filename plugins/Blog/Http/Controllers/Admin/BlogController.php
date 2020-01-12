<?php

namespace Labs\Blog\Http\Controllers\Admin;

use Labs\Blog\Entities;
use Labs\Blog\Http\Requests\Admin\Blog as BlogRequests;
use Labs\Blog\Http\Resource\Admin\BlogResource;
use Labs\Core\Http\Controllers\Controller;

/**
 * Class BlogController
 * @property Entities\Blog model
 * @package Zix\PluginName\Http\Controllers/Admin
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
     * @param BlogRequests\BlogShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BlogRequests\BlogShowRequest $request)
    {
        return datatables()->eloquent($this->model->with('category'))->toJson();
    }

    /**
     * @param BlogRequests\BlogShowRequest $request
     * @param Entities\Blog $blog
     * @return BlogResource
     */
    public function show(BlogRequests\BlogShowRequest $request, Entities\Blog $blog)
    {
        return new BlogResource($blog->load('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogRequests\BlogStoreRequest $request
     * @return BlogResource
     */
    public function store(BlogRequests\BlogStoreRequest $request)
    {
        $model = $this->model->create($request->input());
        return new BlogResource($model);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Entities\Blog $blog
     * @param  BlogRequests\BlogUpdateRequest $request
     * @return BlogResource
     */
    public function update(BlogRequests\BlogUpdateRequest $request, Entities\Blog $blog)
    {
        $blog->update($request->input());
        return new BlogResource($blog);
    }

    /**
     * @param BlogRequests\BlogDestroyRequest $request
     * @param Entities\Blog $blog
     * @return BlogResource
     * @throws \Exception
     */
    public function destroy(BlogRequests\BlogDestroyRequest $request, Entities\Blog $blog)
    {
        $blog->delete();

        return new BlogResource($blog);
    }
}
