<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;
use App\Http\Resources\favoriteResource;
use App\Models\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class favoritesController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/user/add/favorite",
     * operationId="addfavorite",
     * tags={"favorite"},
     * summary="add favorite to user account",
     * description="add favorite to user accounts",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"covent_id"},
     *               @OA\Property(property="covent_id", type="integer"),
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
    public function addFavorite(Request $request)
    {
        $validated = $request->validate([
            'covent_id' =>'required',
        ]);
        $user = Auth::user();
        $covent_id = $request->covent_id;
        if (! $user->favorites->contains($covent_id)) {
            $user->favorites()->attach($covent_id);
            return response()->json(['success' => '1', 'comment' => 'درس موردنظر به علاقه مندی های شما اضافه شد.']);
        }
        return response()->json(['success' => '2', 'comment' => 'درس موردنظر قبلا به علاقه مندی های شما اضافه شده.']);

    }
    /**
     * @OA\Post(
     * path="/api/user/remove/favorite",
     * operationId="removefavorite",
     * tags={"favorite"},
     * summary="remove favorite from user's account",
     * description="remove favorite from user's accounts",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"covent_id"},
     *               @OA\Property(property="covent_id", type="integer"),
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

    public function removeFavorite(Request $request)
    {
        $validated = $request->validate([
            'covent_id' =>'required',
        ]);
        $user = Auth::user();
        $covent_id = $request->covent_id;
        if ($user->favorites->contains($covent_id)) {
            $user->favorites()->detach($covent_id);
            return response()->json(['success' => '1', 'comment' => 'درس موردنظر از علاقه مندی های شما حذف شد.']);
        }
        return response()->json(['success' => '2', 'comment' => 'درس موردنظر قبلا از علاقه مندی های شما حذف شده.']);
    }
    /**
     * @OA\Get(
     * path="/api/user/favorites",
     * operationId="getUserFavorites",
     * tags={"favorite"},
     * summary="Get list of all user favorites",
     * description="return list of user favorites",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */

    public function userFavorites()
    {
        $user = Auth::user();
        $favorites =User::where('id',$user->id)->with('favorites:id,title')->first();
        return  new favoriteResource($favorites);
    }
}
