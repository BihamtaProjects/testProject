@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست گروه های خدمات وبیناری</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{route('services.create')}}" type="button" class="btn btn-primary">افزودن گروه</a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead style="background-color: #7adeee">
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">نام</th>
                <th scope="col">وضعیت</th>
                <th>پلن ها</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1?>
            @foreach($groups as $group)
                <tr>
                    <th scope="row">{{$row++}}</th>
                    <td>{{$group->name}}</td>
                    <td>{{$group->active}}</td>
                    <td><a href="{{route('services.plans',$group)}}"><i class="fa fa-list"></i></a></td>
                    <td><a href="{{route('services.show',$group)}}"><i class="fa fa-edit"></i></a></td>
                    <td>
                        <form action="{{route('services.destroy',$group)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" style="border: none">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
