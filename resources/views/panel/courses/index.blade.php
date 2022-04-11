<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست درس ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{ route('covents.create',['isEvent' => 0])}}" type="button" class="btn btn-primary">افزودن درس</a>
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
            <th scope="col">خلاصه</th>
            <th scope="col">توضیحات</th>
            <th scope="col">پیش نیازها</th>
            <th scope="col">مدت</th>
            <th scope="col">مدت ویدیو</th>
            <th scope="col">سازمان دهنده</th>
            <th scope="col">تاریخ شروع</th>
            <th scope="col">وضعیت</th>
            <th scope="col">اولویت</th>
            <th scope="col">نوع</th>
            <th>جلسات</th>
            <th>سرفصل ها</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1;?>
        @foreach($courses as $course)
            <?php $organizer = \App\Models\Organizer::where('id',$course->organizer_id)->first();
            $type = \App\Models\Type::where('id',$course->type_id)->first();
            $covent = \App\Models\Covent::where('id',$course->id)->first();
            $unit = $covent->unit;
            ?>
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$course->title}}</td>
                <td>{{$course->slug}}</td>
                <td>{!! $course->summary !!}</td>
                <td>{!! $course->description !!}</td>
                <td>{{$course->prerequirement}}</td>
                <td>{{$course->duration}}{{' '.$unit->title}}</td>
                <td>{{$course->video_length}}</td>
                <td>{{$organizer->name}}</td>
                <td>{{$course->start_time}}</td>
                <td>{{$course->active}}</td>
                <td>{{$course->priority}}</td>
                <td>{{$type->name}}</td>
                <td><a href="{{ route('coventsessions.index',['covent'=>$course])}}"><i class="fa fa-calendar-check"></i></a></td>
                <td><a href="{{ route('curriculums.index',['covent'=>$course])}}"><i class="fa fa-tasks"></i></a></td>
                <td><a href="{{ route('covents.show',['isEvent' => 0,$course])}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{ route('covents.destroy',['isEvent' => 0,$course])}}" method="POST">
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
