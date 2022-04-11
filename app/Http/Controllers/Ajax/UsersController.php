<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Ajax;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function search(Request $request)
    {
        return response()->json(
            Role::where('name',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['roles.id', 'roles.name'])->get());
    }
    public function updateUser(Request $request, $id)
    {
        $user_id = $id;
        $user = User::where('id', $user_id)->first();
        $role_id =  $request->input('role_id');
        $user->roles()->attach($role_id);

        return response()->json($user);
    }
}
