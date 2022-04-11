@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    ویرایش سرفصل
                </div>
                <div class="card-body">

                    <form action="{{route('curriculums.update',$curriculum)}}" method="post">
                        {{csrf_field()}}
                        @method('patch')
                        <input class="form-control" type="hidden" name="covent_id" value="{{$curriculum->covent_id}}">
                        <div class="form-group">
                            <label> موضوع </label>
                            <input class="form-control" name="title" placeholder="سرفصل" value="{{$curriculum->title}}">
                        </div>
                        <div class="form-group">
                            <label> شماره بخش </label>
                            <input class="form-control" name="partnum" placeholder="شماره بخش" value="{{$curriculum->partnum}}">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($curriculum->active==1) checked @endif>
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

