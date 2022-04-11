<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\courseResource;
use App\Http\Resources\eventResource;
use App\Http\Resources\groupCollection;
use App\Models\Covent;
use App\Models\Selectedgroup;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoventsController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/selectedCovents",
     * operationId="returnSelectedCovents",
     * tags={"selected"},
     * summary="return list of selected covents",
     * description="return list of selected covents in diffrent groups",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"page_name"},
     *               @OA\Property(property="page_name", type="text"),
     *               @OA\Property(property="session_id", type="text"),
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function selectedCovents(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'session_id' => 'nullable',
            'page_name' =>'required',
        ]);
        $groups = Selectedgroup::where('page_name',$request->page_name)->orderBy('priority')->get();

        return  new groupCollection($groups);

    }
    /**
     * @OA\Post(
     * path="/api/covent",
     * operationId="returnspecificCovent",
     * tags={"covent"},
     * summary="return a specific Covent",
     * description="return a specific Covent",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"covent_slug"},
     *               @OA\Property(property="covent_slug", type="text"),
     *               @OA\Property(property="session_id", type="text"),
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */

    public function specificCovent(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'nullable',
            'covent_slug' =>'required',
        ]);
            $covent = Covent::where('slug',$request->input('covent_slug'))->withoutGlobalScope('ActiveCovents')->with(['comments.user:id,first_name,last_name','faqs','keywords','curriculums.subcurriculums','instructors.user:id,first_name,last_name','organizer','type'])->first();
           if($covent) {
               if ($covent->is_event == 0) {
                   return new courseResource($covent);
               } elseif ($covent->is_event == 1) {
                   return new eventResource($covent);
               }
           }else{
               return Response()->json('the covent with this id does not exists');
           }
    }
}
