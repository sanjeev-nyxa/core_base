<?php namespace Labs\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Labs\Core\Http\Requests\Admin\Permission as PermissionRequests;
use Labs\Core\Http\Resources\Admin\PermissionResource;
use Labs\Core\Entities;


/**
 * Class PermissionController
 * @property Entities\Permission model
 * @package Labs\Core\Http\Controllers
 * @resource Admin Permissions
 *
 */
class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     * @param Entities\Permission $model
     */
    public function __construct(Entities\Permission $model)
    {
        $this->model = $model;
    }

    /**
     * @SWG\Get(
     *     path="/admin/permissions",
     *     tags={"Admin Permissions"},
     *     summary="Get Permissions List",
     *     @SWG\Response(
     *          response=200,
     *          description="ORACLE Fluent Query Response.",
     *      ),
     * ),
     * @param PermissionRequests\PermissionShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PermissionRequests\PermissionShowRequest $request)
    {
        return datatables()->eloquent($this->model->query())->toJson();
    }

    /**
     * @SWG\Get(
     *     path="/admin/permissions/{permission}",
     *     tags={"Admin Permissions"},
     *     summary="Get Permission",
     *     @SWG\Parameter(
     *          name="permission",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminPermissionShowRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="PermissionResource.",
     *      ),
     * ),
     * @param PermissionRequests\PermissionShowRequest $request
     * @param Entities\Permission $permission
     * @return PermissionResource
     */
    public function show(PermissionRequests\PermissionShowRequest $request, Entities\Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * @SWG\Post(
     *     path="/admin/permissions",
     *     tags={"Admin Permissions"},
     *     summary="Create New Permission",
     *     @SWG\Parameter(
     *          name="permission",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminPermissionStoreRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="PermissionResource.",
     *      ),
     * ),
     * @param  PermissionRequests\PermissionStoreRequest $request
     * @return PermissionResource
     */
    public function store(PermissionRequests\PermissionStoreRequest $request)
    {
        $model = $this->model->create($request->input());

        return new PermissionResource($model);
    }


    /**
     * @SWG\Put(
     *     path="/admin/permissions/{permission}",
     *     tags={"Admin Permissions"},
     *     summary="Update Permission",
     *     @SWG\Parameter(
     *          name="permission",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminPermissionUpdateRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="PermissionResource.",
     *      ),
     * ),
     * @param  Entities\Permission  $permission
     * @param  PermissionRequests\PermissionUpdateRequest $request
     * @return PermissionResource
     */
    public function update(PermissionRequests\PermissionUpdateRequest $request, Entities\Permission $permission)
    {
        $permission->update($request->input());

        return new PermissionResource($permission);
    }


    /**
     * @SWG\Delete(
     *     path="/admin/permissions/{permission}",
     *     tags={"Admin Permissions"},
     *     summary="Delete Permission",
     *     @SWG\Parameter(
     *          name="permission",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="PermissionResource.",
     *      ),
     * ),
     * @param PermissionRequests\PermissionDestroyRequest $request
     * @param Entities\Permission $permission
     * @return PermissionResource
     * @throws \Exception
     */
    public function destroy(PermissionRequests\PermissionDestroyRequest $request, Entities\Permission $permission)
    {
        $permission->delete();

        return new PermissionResource($permission);
    }
}