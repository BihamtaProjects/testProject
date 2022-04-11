@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                  ویرایش پلن
                </div>
                <div class="card-body">

                    <form action="{{route('plan.update',$plan->id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" value="{{$plan->name}}" placeholder="نام گروه">
                        </div>
                        <div class="form-group">
                            <label> محدودیت تعداد کاربران </label>
                            <input class="form-control" name="userlimit" placeholder="محدودیت تعداد کاربران" value="{{$plan->userlimit}}">
                        </div>
                        <div class="form-group">
                            <label> محدودیت تعداد ویدیوها </label>
                            <input class="form-control" name="videolimit" placeholder="محدودیت تعداد ویدیو ها" value="{{$plan->videolimit}}">
                        </div>
                        <div class="form-group">
                            <label> محدودیت زمانی </label>
                            <input class="form-control" name="timelimit" placeholder="محدودیت زمانی" value="{{$plan->timelimit}}">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($plan->active==1) checked @endif>
                            <label class="form-check-label" for="flexCheckChecked" style="padding-right: 15px;">
                                فعال
                            </label>

                        </div>


                        <button type="submit" class="btn btn-primary">ثبت</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

