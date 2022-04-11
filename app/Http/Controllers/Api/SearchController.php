<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoventsCollection;
use App\Http\Resources\searchCollection;
use App\Models\Covent;
use App\Models\Price;
use App\Models\Subcurriculum;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Traits\lastPriceTrait;

class SearchController extends Controller
{
    use LastPriceTrait;
    /**
     * @OA\Post(
     * path="/api/search",
     * operationId="returnsearchresult",
     * tags={"search"},
     * summary="return search result",
     * description="return search result.
      isFree and hasDiscount must be 0 or 1.
      isEvent could be null, 0 or 1",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"isFree","hasDiscount"},
     *               @OA\Property(property="subject_id", type="integer"),
     *               @OA\Property(property="isFree", type="integer"),
     *               @OA\Property(property="hasDiscount", type="integer"),
     *               @OA\Property(property="keyword", type="string"),
     *               @OA\Property(property="isEvent", type="integer"),
     *               @OA\Property(property="type_id", type="integer"),
     *               @OA\Property(property="organizer_id", type="integer"),
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

    public function search(Request $request)
    {

        $validated = $request->validate([
            'subject_id' => 'nullable|numeric',
            'keyword' =>'nullable|string',
            'isEvent' => 'nullable|boolean',
            'isFree' => 'required|boolean',
            'type_id' => 'nullable|numeric',
            'organizer_id' => 'nullable|numeric',
            'hasDiscount' => 'required|boolean',

        ]);
        $query = Covent::query();

        $query->when(request()->has('subject_id'),function($q) {

                $q->wherehas('subjects', function ($q) {
                    $q->where('subjects.id', request('subject_id'));
                });
        })
            ->when(request()->has('isEvent'),function($q)  {
            $q->where('is_event',request('isEvent'));
        })
            ->when(request('hasDiscount')==1,function ($q) {
                $q->wherehas('prices', function ($q) {
                    $q->active()->where('discount', '>', 1);
                });
                    })
            ->when(request('isFree')==1,function ($q) {
                $q->wherehas('prices', function ($q) {
                    $q->active()->where('price', 0);
                });
                    })
            ->when(request()->has('keyword'),function($q) {
                $q->with('keywords')->where(function ($query) {
                    $query->where('title', 'LIKE', '%' . request('keyword') . '%')
                        ->orwhere('description', 'LIKE', '%' . request('keyword') . '%')
                        ->orwhereHas('keywords', function ($query) {
                            $query->where('title', 'LIKE', "% request('keyword') %");
                        });
                });
            })

            ->when(request()->has('type_id'),function($q) {
                $q->where('type_id',request('type_id'));
            })
            ->when(request()->has('organizer_id'),function($q) {
                $q->where('organizer_id',request('organizer_id'));
            });
        $covents = $query->paginate(10);

        return  new searchCollection($covents);
    }

}
