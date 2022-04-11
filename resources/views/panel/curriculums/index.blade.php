
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست درس ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{ route('curriculums.create',['covent'=>$covent])}}" type="button" class="btn btn-primary">افزودن سرفصل</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    $row = 1;
    ?>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">موضوع</th>
            <th scope="col">بخش</th>
            <th scope="col">وضعیت</th>
            <th>عناوین آموزشی</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>

        @foreach($curriculums as $curriculum)
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$curriculum->title}}</td>
                <td>{{$curriculum->partnum}}</td>
                <td>{{$curriculum->active}}</td>
                    <td><a href="{{ route('subcurriculums.index',['curriculum'=>$curriculum->id])}}"><i class="fa fa-tasks"></i></a></td>
                    <td><a href="{{ route('curriculums.show',['curriculum'=>$curriculum->id])}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{ route('curriculums.destroy',['curriculum'=>$curriculum->id])}}" method="POST">
                        @csrf
                        @method('delete')
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
