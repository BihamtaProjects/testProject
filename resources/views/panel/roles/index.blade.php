@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">نقش ها</h4>
            </div>
 <div class="col col-md-4">
     <div style="padding: 15px">
     <a  href="{{route('roles.create')}}" type="button" class="btn btn-primary">افزودن نقش</a>
            </div>
 </div>
            </div>
        </div>
        <table class="table">
            <thead style="background-color: #7adeee">
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">نام</th>
                <th scope="col">عنوان کوتاه</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1?>
            {{--            @if($users)--}}
            @foreach($roles as $role)
                <tr>
                    <th scope="row">{{$row++}}</th>
                    <td>{{$role->name}}</td>
                    <td>{{$role->slug}}</td>

                    <td><a href="{{route('roles.show',$role)}}"><i class="fa fa-edit"></i></a></td>
                    <td>
                        <form action="{{route('roles.destroy',$role)}}" method="POST">
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
