<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypesController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/allTypes",
     * operationId="getAllTypes",
     * tags={"types"},
     * summary="Get list of all types",
     * description="return list of all types",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function allTypes()
    {
        $types = Type::active()->get();
        return response()->json($types);
    }
}
