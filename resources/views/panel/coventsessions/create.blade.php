@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن جلسه
                </div>
                <div class="card-body">
                    <form action="{{ route('coventsessions.store')}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input class="form-control" type="hidden" name="covent_id" value="{{$covent}}">
                        <div class="form-group">
                            <label>مدت</label>
                            <input class="form-control" name="duration" placeholder="مدت">
                        </div>
                        <div class="form-group">
                            <label>مدت ویدیو</label>
                            <input class="form-control" name="video_length" placeholder="مدت ویدیو" >
                        </div>
                        <div class="form-group">
                            <label>مقیاس زمان</label>
                            <select class="form-select" aria-label="سازمان دهنده" name="unit_id">
                                <option selected>انتخاب مقیاس زمان</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>تاریخ شروع</label>
                            <input class="form-control" name="start_time" placeholder="تاریخ شروع">
                        </div>
                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت">
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

