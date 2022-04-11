<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست رویداد ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{ route('covents.create',['isEvent' => 1])}}" type="button" class="btn btn-primary">افزودن رویداد</a>
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
            <th scope="col">سرفصل ها</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1;?>
        @foreach($events as $event)
            <?php $organizer = \App\Models\Organizer::where('id',$event->organizer_id)->first();
            $type = \App\Models\Type::where('id',$event->type_id)->first();
            $covent = \App\Models\Covent::where('id',$event->id)->first();
            $unit = $covent->unit;
            ?>
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$event->title}}</td>
                <td>{{$event->slug}}</td>
                <td>{!! $event->summary !!}</td>
                <td>{!!$event->description!!}</td>
                <td>{{$event->prerequirement}}</td>
                <td>{{$event->duration}}{{' '.$unit->title}}</td>
                <td>{{$event->video_length}}</td>
                <td>{{$organizer->name}}</td>
                <td>{{$event->start_time}}</td>
                <td>{{$event->active}}</td>
                <td>{{$event->priority}}</td>
                <td>{{$type->name}}</td>
                <td><a href="{{ route('coventsessions.index',['covent'=>$event])}}"><i class="fa fa-calendar-check"></i></a></td>
                <td><a href="{{ route('curriculums.index',['covent'=>$event])}}"><i class="fa fa-tasks"></i></a></td>
                <td><a href="{{ route('covents.show',['isEvent' => 1,$event])}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{ route('covents.destroy',[$event,'isEvent'=>1])}}" method="POST">
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
