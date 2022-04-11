<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryItemCollection;
use App\Http\Resources\subjectCollection;
use App\Models\Subject;
use Illuminate\Http\Request;
use phpseclib3\File\ASN1\Maps\SubjectInfoAccessSyntax;

class SubjectsController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/allSubjects",
     * operationId="getAllSubjects",
     * tags={"subjects"},
     * summary="Get list of all subjects and sub-branches",
     * description="return list of subjects with their sub-branches",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="slug", type="text"),
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
    public function allSubjects(Request $request)
    {
        if($request->input('slug')==null) {
            $subjects = Subject::active()->parent()->get();
        }elseif($request->input('slug')!=null){
            $subjects = Subject::active()->parent()->where('slug',$request->input('slug'))->get();
        }
        return  new subjectCollection($subjects);
    }
}
