<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizersController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/allOrganizers",
     * operationId="getAllOrganizers",
     * tags={"organizers"},
     * summary="Get list of all organizers",
     * description="return list of all organizers",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function allOrganizers()
    {
      $organizers = Organizer::active()->get();
      return response()->json($organizers);
    }
}
