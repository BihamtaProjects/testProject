
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست قیمت های پلن</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{route('price.create',$plan_id)}}" type="button" class="btn btn-primary">افزودن قیمت</a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead style="background-color: #7adeee">
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">مدت</th>
                <th scope="col">تعداد روزهای رایگان</th>
                <th scope="col">وضعیت</th>
                <th scope="col">قیمت</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1?>
            @foreach($prices as $price)
                <tr>
                    <th scope="row">{{$row++}}</th>
                    <td>{{$price->duration}}</td>
                    <td>{{$price->freeday}}</td>
                    <td>{{$price->active}}</td>
                    <td>{{$price->price}}</td>
                    <td><a href="{{route('price.edit',$price->id)}}"><i class="fa fa-edit"></i></a></td>
                    <td>
                        <form action="{{route('price.destroy',$price->id)}}" method="Post">
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
