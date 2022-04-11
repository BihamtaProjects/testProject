@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
        <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">کاربران</h4>
            </div>
            <div class="col col-md-7">
                <form action="{{route('users.search')}}" method="post" style="width: 70%">
                    {{csrf_field()}}
                <div class="input-group mb-3" style="padding: 15px">
                    <input type="text" style="border-top-right-radius:10px;border-bottom-right-radius: 10px;border-top-left-radius:0px;border-bottom-left-radius: 0px;" class="form-control" placeholder="جستجو" name="keyword">
                    <div class="input-group-append ">
                        <select  name="role" style="background-color: #9fcdff;border-color: #9fcdff">
                            <option value="0" selected>نقش ها</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>

                        </div>

                    <div class="input-group-append">
                        <button type="submit" href="{{route('users.search')}}" style="border-top-right-radius:0px;border-bottom-right-radius: 0px;border-top-left-radius:10px;border-bottom-left-radius: 10px;" class="btn btn-outline-secondaryb btn-primary" type="button" id="button-addon2"> <i class="nav-icon fas fa-search"></i></button>
                    </div>

        </div>
                </form>
            </div>

        </div>
        <table class="table">
            <thead style="background-color: #7adeee">
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">نام</th>
                <th scope="col"> نام خانوادگی</th>
                <th scope="col">تلفن</th>
                <th scope="col">ایمیل</th>
                <th scope="col">نقش ها</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1?>
{{--            @if($users)--}}
            @foreach($users as $user)
                <?php $userRoles = $user->roles()->pluck('name')?>
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->mobile_number}}</td>
                <td>{{$user->email}}</td>
                <td>{{$userRoles}}</td>
                <td><a href="{{route('users.show',$user)}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{route('users.destroy',$user)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button type="submit" style="border: none">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
                @endforeach
{{--                @endif--}}
            </tbody>
        </table>
    </div>
@endsection
