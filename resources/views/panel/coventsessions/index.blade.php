
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">لیست درس ها</h4>
            </div>
            <div class="col col-md-4">
                <div style="padding: 15px">
                    <a  href="{{ route('coventsessions.create',['covent'=>$covent])}}" type="button" class="btn btn-primary">افزودن جلسه</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    $row = 1; $count = count($sessions);
    ?>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">مدت</th>
            <th scope="col">تاریخ شروع</th>
            <th scope="col">وضعیت</th>
            <th scope="col">اولویت</th>
            @if($count>1)
            <th>ویرایش</th>
            @endif
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>

        @foreach($sessions as $session)
            <?php
//            $session = \App\Models\Coventsession::where('id',$session->id)->first();
            $unit = \App\Models\Unit::where('id',$session->unit_id)->first();
           ?>
            <tr>
                <th scope="row">{{$row++}}</th>
                <td>{{$session->duration}}{{' '.$unit->title}}</td>
                <td>{{$session->start_time}}</td>
                <td>{{$session->active}}</td>
                <td>{{$session->priority}}</td>
                @if($count>1)
                <td><a href="{{ route('coventsessions.show',['coventsession'=>$session])}}"><i class="fa fa-edit"></i></a></td>
                @endif
                <td>
                    <form action="{{ route('coventsessions.destroy',['coventsession'=>$session])}}" method="POST">
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
