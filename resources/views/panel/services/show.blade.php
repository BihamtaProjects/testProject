@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    ویرایش گروه
                </div>
                <div class="card-body">

                    <form action="{{route('services.update',$group)}}" method="post">
                        {{csrf_field()}}
                        @method('patch')
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" value="{{$group->name}}">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($group->active==1) checked @endif>
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

