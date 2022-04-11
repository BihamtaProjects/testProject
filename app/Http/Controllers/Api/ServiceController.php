<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/allServices",
     * operationId="getAllServices",
     * tags={"services"},
     * summary="Get list of all services with plans and prices",
     * description="return list of services with plans and prices",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function allServices()
    {

        $services = ServiceGroup::select()->with('plans.prices')->get();
        return response()->json($services);
    }
}
