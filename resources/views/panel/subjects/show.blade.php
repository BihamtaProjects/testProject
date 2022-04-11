@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن دسته بندی
                </div>
                <div class="card-body">
                    <form action="{{route('subjects.update',$subject)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @method('patch')
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" placeholder="نام دسته بندی" value="{{$subject->name}}">
                        </div>
                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت" value="{{$subject->priority}}">
                        </div>
                        <div class="form-group">
                            <label>عکس </label>
                            <input type="file" id="image" name="image" value="{{$subject->image}}">
                        </div>
                        <div class="form-group">
                            <label>آیکون</label>
                            <input type="file" id="icon" name="icon" value="{{$subject->icon}}">
                        </div>
                        <div class="form-group">
                            <?php $subParent = $subject->parent_id;?>
                            <label>دسته بندی اصلی</label>
                            <select class="form-select" aria-label="Default select example" name="parent_id">
                                <option value="0" @if($subject->parent_id==0) selected @endif>دسته اصلی</option>
                                @foreach($mainSubjects as $main)
                                    <option value="{{$main->id}}" @if($subParent==$main->id) selected @endif>{{$main->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <input class="form-control" name="summary" placeholder="خلاصه" value="{{$subject->summary}}">
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <input class="form-control" name="description" placeholder="توضیحات" value="{{$subject->description}}">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($subject->active==1) checked @endif>
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

