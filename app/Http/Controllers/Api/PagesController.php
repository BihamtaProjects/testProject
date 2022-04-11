<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/page",
     * operationId="return a page",
     * tags={"Page"},
     * summary="return a page",
     * description="you should choose page_link or page_id or none of them",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="page_slug", type="text"),
     *               @OA\Property(property="page_link", type="text"),
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

    public function specificPage(Request $request)
    {
        $validated = $request->validate([
            'page_slug' => 'nullable',
            'page_link' =>'nullable',
        ]);

        if($request->input('page_slug')){
          $page = Page::where('slug',$request->input('page_slug'))->first();
        }
        elseif($request->input('page_link')){
            $page = Page::where('link',$request->input('page_link'))->first();
        }else{
            $page = Page::all();
        }
        return response()->json($page);
    }
}
