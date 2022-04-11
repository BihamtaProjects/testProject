@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن صفحه جدید
                </div>
                <div class="card-body">
                    <form action="{{ route('pages.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" placeholder="نام " required>
                        </div>
                        <div class="form-group">
                            <label for="image">اپلود عکس</label>
                        <input type="file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label> عنوان </label>
                            <input class="form-control" name="title" placeholder="عنوان" required>
                        </div>
                        <div class="form-group">
                            <label>کلمه کلیدی</label>
                            <input class="form-control" name="keyword" placeholder="کلمه کلیدی" required>
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <textarea class="ckeditor form-control" name="summary" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <textarea class="ckeditor form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>محتوا</label>
                            <textarea class="ckeditor form-control" name="content" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>لینک</label>
                            <input class="form-control" name="link" placeholder="لینک" required>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
