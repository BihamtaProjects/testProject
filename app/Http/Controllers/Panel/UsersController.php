<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('panel.users.index',compact('users','roles'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('panel.users.show',compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
        ]);

        $input = $request->all();
        $user->fill($input)->save();

        return redirect()->route('users.index')
            ->with('success','کاربر مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('warning','کاربر مورد نظر با موفقیت حذف شد. ');
    }

    public function destroyRole(User $user,Role $role)
    {
        $user->roles()->detach($role->id);
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $roles = Role::all();
        if(request('keyword')==null && request('role')==0){
            $users = User::all();
        }else{


            $query = User::query();
            $keyword = $request->input('keyword');
            $role_id= $request->input('role');
            $query->when($role_id && $role_id!=null ,function($q) use($role_id) {
            $q->with('roles')->whereHas('roles', function ($q) use($role_id){
                $q->where('roles.id',$role_id);
            });
            })->when( $keyword &&  $keyword!=null ,function($q)  use($keyword){
                   $q->where(function($query) use($keyword){
                         $query->where('first_name', 'LIKE', '%' . $keyword . '%')
                         ->orwhere('last_name', 'LIKE', '%' . $keyword . '%')
                             ->orwhere('mobile_number', request('keyword'))
                             ->orwhere('email', 'LIKE', '%' . request('keyword') . '%');
                    });
                    });
               $users = $query->paginate(10);


    }


        return view('panel.users.index',compact('users','roles'));
    }

}
