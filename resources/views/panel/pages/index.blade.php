@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">صفحه ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{route('pages.create')}}" type="button" class="btn btn-primary">افزودن صفحه</a>
                </div>
            </div>
        </div>
    </div>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام</th>
            <th scope="col">عنوان</th>
            <th scope="col">عنوان کوتاه</th>
            <th scope="col">کلمه کلیدی</th>
            <th scope="col">خلاصه</th>
            <th scope="col">توضیحات</th>
            <th scope="col">محتوا</th>
            <th scope="col">لینک</th>
            <th scope="col">کلمه کلیدی</th>
            <th scope="col">وضعیت</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1?>
        @foreach($pages as $page)
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$page->name}}</td>
                <td>{{$page->title}}</td>
                <td>{{$page->slug}}</td>
                <td>{{$page->keyword}}</td>
                <td>{!! $page->summary !!}</td>
                <td>{!! $page->description !!}</td>
                <td>{!! $page->content !!}</td>
                <td>{{$page->link}}</td>
                <td>{{$page->keyword}}</td>
                <td>{{$page->active}}</td>

                <td><a href="{{route('pages.show',$page)}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{route('pages.destroy',$page)}}" method="POST">
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
