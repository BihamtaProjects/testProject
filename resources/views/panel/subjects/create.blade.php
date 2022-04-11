@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن دسته بندی
                </div>
                <div class="card-body">
                    <form action="{{route('subjects.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" placeholder="نام دسته بندی">
                        </div>
                        <div class="form-group">
                            <label>عکس </label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label>آیکون</label>
                            <input type="file" name="icon">
                        </div>
                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت">
                        </div>
                        <div class="form-group">
                            <label>دسته بندی اصلی</label>
                            <select class="form-select" aria-label="Default select example" name="parent_id">
                                <option value="0" selected>دسته بندی اصلی</option>
                                @foreach($mainSubjects as $main)
                                <option value="{{$main->id}}">{{$main->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <input class="form-control" name="summary" placeholder="خلاصه">
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <input class="form-control" name="description" placeholder="توضیحات">
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

