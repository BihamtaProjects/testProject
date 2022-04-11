@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن رویداد
                </div>
                <div class="card-body">
                    <form action="{{ route('covents.store',['isEvent' => 1])}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="title" placeholder="نام">
                        </div>
                        <div class="form-group">
                            <label>عکس </label>
                            <input type="file" id="main_pic" name="main_pic">
                        </div>
                        <div class="form-group">
                            <label>ویدیو</label>
                            <input type="file" id="main_video" name="main_video">
                        </div>
                        <div class="form-group">
                            <label>مدت ویدیو</label>
                            <input class="form-control" name="video_length" placeholder="مدت ویدیو">
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <textarea class="ckeditor form-control" name="summary"></textarea>
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <textarea class="ckeditor form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>پیش نیازها</label>
                            <input class="form-control" name="prerequirement" placeholder="پیش نیازها">
                        </div>
                        <div class="form-group">
                            <label>مدت</label>
                            <input class="form-control" name="duration" placeholder="مدت">
                        </div>
                        <div class="form-group">
                            <label>مقیاس زمان</label>
                            <select class="form-select" aria-label="سازمان دهنده" name="unit_id">
                                <option selected>انتخاب مقیاس زمان</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->title}}</option>
                                @endforeach
                            </select>.
                        </div>
                        <div class="form-group">
                            <label>سازمان دهنده</label>
                            <select class="form-select" aria-label="سازمان دهنده" name="organizer_id">
                                <option selected>انتخاب سازمان دهنده</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{$organizer->id}}">{{$organizer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>تاریخ شروع</label>
                            <input class="date-picker"  name="start_time">
                        </div>
                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت">
                        </div>
                        <div class="form-group">
                            <label>نوع</label>
                            <select class="form-select" aria-label="نوع" name="type_id">
                                <option selected>انتخاب نوع</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
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

@section('third_party_scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>

    <script type="text/javascript">

        jQuery.noConflict();
        jQuery(document).ready(function($){
            $(".date-picker").pDatepicker({
                altField: '#dateTime',
                altFormat:'gregorian',
                observer: true,
                format: 'YYYY-MM-DD HH:MM',
                calendar:{
                    persian:{
                        locale:'en'
                    }
                }
            });
        });

    </script>

@endsection
