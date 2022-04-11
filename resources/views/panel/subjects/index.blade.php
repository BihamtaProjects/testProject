<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">دسته بندی ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{route('subjects.create')}}" type="button" class="btn btn-primary">افزودن دسته بندی</a>
                </div>
            </div>
        </div>
    </div>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام</th>
            <th scope="col">اولویت</th>
            <th scope="col">وضعیت</th>
            <th scope="col">زیردسته</th>
            <th scope="col">خلاصه</th>
            <th scope="col">توضیحات</th>
            <th>زیر دسته ها</th>
            <th>ویرایش</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1;?>
        @foreach($subjects as $subject)
            <?php $parentId = $subject->parent_id;?>
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$subject->name}}</td>
                <td>{{$subject->priority}}</td>
                <td>{{$subject->active}}</td>
                @if($parentId==0)
                    <td>دسته اصلی</td>
                @else

                 <?php
                    $parent = Subject::where('id',$parentId)->first();?>
                    <td>{{$parent->name}}</td>
                    @endif
                <td>{{$subject->summary}}</td>
                <td>{{$subject->description}}</td>

@if($subject->parent_id==0)
                <td><a href="{{route('subjects.subSubjects',$subject)}}"><i class="fa fa-tasks"></i></a></td>
                @else
    <td></td>
                @endif
                <td><a href="{{route('subjects.show',$subject)}}"><i class="fa fa-edit"></i></a></td>
                <td>
                    <form action="{{route('subjects.destroy',$subject)}}" method="POST">
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
