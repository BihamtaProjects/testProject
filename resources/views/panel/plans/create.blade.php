@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن پلن
                </div>
                <div class="card-body">

                    <form action="{{route('services.plan.store',$group_id)}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" placeholder="نام گروه">
                        </div>
                        <div class="form-group">
                            <label> محدودیت تعداد کاربران </label>
                            <input class="form-control" name="userlimit" placeholder="محدودیت تعداد کاربران">
                        </div>
                        <div class="form-group">
                            <label> محدودیت تعداد ویدیوها </label>
                            <input class="form-control" name="videolimit" placeholder="محدودیت تعداد ویدیو ها">
                        </div>
                        <div class="form-group">
                            <label> محدودیت زمانی </label>
                            <input class="form-control" name="timelimit" placeholder="محدودیت زمانی">
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="active" value="0" />
                            <input class="form-check-input" type="checkbox" value="1" id="active" name="active" {{ old('active') ? 'checked="checked"' : '' }}>
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

