@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                   ویرایش صفحه
                </div>
                <div class="card-body">
                    <form action="{{ route('pages.update',$page->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @method('patch')
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" value="{{$page->name}}" placeholder="نام ">
                        </div>
                        <div class="form-group">
                            <label for="image">اپلود عکس</label>
                            <input type="file" id="image" name="image" value="{{$page->image}}">
                        </div>
                        <div class="form-group">
                            <label> عنوان </label>
                            <input class="form-control" name="title" value="{{$page->title}}" placeholder="عنوان">
                        </div>
                        <div class="form-group">
                            <label>کلمه کلیدی</label>
                            <input class="form-control" name="keyword" value="{{$page->keyword}}" placeholder="کلمه کلیدی">
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <textarea class="ckeditor form-control"  name="summary">{{$page->summary}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <textarea class="ckeditor form-control"  name="description">{{$page->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>محتوا</label>
                            <textarea class="ckeditor form-control" name="content">{{$page->content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>لینک</label>
                            <input class="form-control" name="link" placeholder="لینک" value="{{$page->link}}">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($page->active==1) checked @endif>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
