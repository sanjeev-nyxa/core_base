<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/customer/{customerId}/rate",
     *   summary="List customer rates",
     *   operationId="getCustomerRates",
     *   @SWG\Parameter(
     *     name="customerId",
     *     in="path",
     *     description="Target customer.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     description="Filter results based on query string value.",
     *     required=false,
     *     enum={"active", "expired", "scheduled"},
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function index()
    {
        
    }

    /**
     * @SWG\Response(
     *      response="Json",
     *      description="the basic response",
     *      @SWG\Schema(
     *          @SWG\Property(
     *              type="boolean",
     *              property="success"
     *          ),
     *          @SWG\Property(
     *              property="data"
     *          ),
     *          @SWG\Property(
     *              property="errors",
     *              type="object"
     *          ),
     *          @SWG\Property(
     *              property="token",
     *              type="string"
     *          )
     *      )
     * )
     *
     */
    public function show()
    {

    }
}
