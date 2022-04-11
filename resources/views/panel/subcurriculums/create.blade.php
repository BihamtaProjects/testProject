@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن برنامه درسی
                </div>
                <div class="card-body">

                    <form action="{{ route('subcurriculums.store')}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input class="form-control" type="hidden" name="curriculum_id" value="{{$curriculum->id}}">
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="title" placeholder="نام ">
                        </div>
                        <div class="form-group">
                            <label>ویدیو</label>
                            <input type="file" id="video_preview" name="video_preview">
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
