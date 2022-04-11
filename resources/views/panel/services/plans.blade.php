@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست پلن ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{route('services.plan.create',$group_id)}}" type="button" class="btn btn-primary">افزودن پلن</a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead style="background-color: #7adeee">
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">نام</th>
                <th scope="col">محدودیت تعداد کاربران</th>
                <th scope="col">محدودیت تعداد ویدیوها</th>
                <th scope="col">مدت</th>
                <th scope="col">وضعیت</th>
                <th>قیمت ها</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1?>
            @foreach($plans as $plan)
                <tr>
                    <th scope="row">{{$row++}}</th>
                    <td>{{$plan->name}}</td>
                    <td>{{$plan->userlimit}}</td>
                    <td>{{$plan->videolimit}}</td>
                    <td>{{$plan->timelimit}}</td>
                    <td>{{$plan->active}}</td>
                    <td><a href="{{route('services.plan.prices',$group_id)}}"><i class="fas fa-money-bill"></i></a></td>
                    <td><a href="{{route('plan.edit',$plan->id)}}"><i class="fa fa-edit"></i></a></td>
                    <td>
                        <form action="{{route('plan.destroy',$plan->id)}}" method="Post">
                            @csrf
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
