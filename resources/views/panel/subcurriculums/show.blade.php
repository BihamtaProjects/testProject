@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن برنامه درسی
                </div>
                <div class="card-body">

                    <form action="{{ route('subcurriculums.update',['subcurriculum'=>$subcurriculum->id])}}" method="post"  enctype="multipart/form-data">
                        @method('patch')
                        {{csrf_field()}}
                        <input class="form-control" type="hidden" name="curriculum_id" value="{{$curriculum->id}}">
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="title" placeholder="نام " value="{{$subcurriculum->title}}">
                        </div>
                        <div class="form-group">
                            <label>ویدیو</label>
                            <input type="file" id="video_preview" name="video_preview" value="{{$subcurriculum->video_preview}}">
                        </div>
                        <div class="form-group">
                            <label>مدت ویدیو</label>
                            <input class="form-control" name="video_length" placeholder="مدت ویدیو" value="{{$subcurriculum->video_length}}">
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <textarea class="ckeditor form-control" name="summary" >{{$subcurriculum->summary}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <textarea class="ckeditor form-control" name="description">{{$subcurriculum->description}}</textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($subcurriculum->active==1) checked @endif>
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
