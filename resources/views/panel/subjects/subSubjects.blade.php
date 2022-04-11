
<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست زیر دسته ها</h4>
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
            <th scope="col">حذف</th>
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
