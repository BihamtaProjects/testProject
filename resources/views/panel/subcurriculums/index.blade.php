<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست برنامه آموزشی</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{ route('subcurriculums.create',['curriculum' => $curriculum->id])}}" type="button" class="btn btn-primary">افزودن برنامه آموزشی</a>
                </div>
            </div>
        </div>
    </div>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام</th>
            <th scope="col">خلاصه</th>
            <th scope="col">توضیحات</th>
            <th scope="col">مدت ویدیو</th>
            <th scope="col">وضعیت</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1;?>
        @foreach($subcurriculums as $subcurriculum)
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$subcurriculum->title}}</td>
                <td>{!! $subcurriculum->summary !!}</td>
                <td>{!! $subcurriculum->description !!}</td>
                <td>{{$subcurriculum->video_length}}</td>
                <td>{{$subcurriculum->active}}</td>
                <td><a href="{{route('subcurriculums.show',['subcurriculum'=>$subcurriculum->id])}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{route('subcurriculums.destroy',['subcurriculum' => $subcurriculum->id])}}" method="POST">
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
