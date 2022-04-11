@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن سرفصل
                </div>
                <div class="card-body">

                    <form action="{{route('curriculums.store')}}" method="post">
                        {{csrf_field()}}
                        <input class="form-control" type="hidden" name="covent_id" value="{{$covent}}">
                        <div class="form-group">
                            <label> موضوع </label>
                            <input class="form-control" name="title" placeholder="سرفصل">
                        </div>
                        <div class="form-group">
                            <label> شماره بخش </label>
                            <input class="form-control" name="partnum" placeholder="شماره بخش">
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

