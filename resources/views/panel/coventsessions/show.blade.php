@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    ویرایش جلسه
                </div>
                <div class="card-body">
                    <form action="{{ route('coventsessions.update',$session)}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        @method('patch')
                        <input class="form-control" type="hidden" name="covent_id" value="{{$covent->id}}">
                        <div class="form-group">
                            <label>مدت</label>
                            <input class="form-control" name="duration" placeholder="مدت" value="{{$session->duration}}">
                        </div>
                        <div class="form-group">
                            <label>مدت ویدیو</label>
                            <input class="form-control" name="video_length" placeholder="مدت ویدیو" value="{{$session->video_length}}">
                        </div>
                        <div class="form-group">
                            <label>مقیاس زمان</label>
                            <select class="form-select" name="unit_id">
                                <?php $mainunit = App\Models\Unit::where('id',$covent->unit_id)->first() ?>
                                <option selected>انتخاب مقیاس زمان</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}" @if($unit->id==$mainunit->id) selected @endif>{{$unit->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>تاریخ شروع</label>
                            <input class="form-control" name="start_time" placeholder="تاریخ شروع" value="{{$session->start_time}}">
                        </div>
                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت" value="{{$session->priority}}">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($session->active==1) checked @endif>
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

