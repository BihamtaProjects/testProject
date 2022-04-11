@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن قیمت
                </div>
                <div class="card-body">

                    <form action="{{route('price.update',$price->id)}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label>مدت </label>
                            <input class="form-control" name="duration" placeholder="مدت" value="{{$price->duration}}">
                        </div>
                        <div class="form-group">
                            <label> تعداد روزهای رایگان </label>
                            <input class="form-control" name="freeday" placeholder="تعداد روزهای رایگان " value="{{$price->freeday}}">
                        </div>
                        <div class="form-group">
                            <label>قیمت</label>
                            <input class="form-control" name="price" placeholder="قیمت" value="{{$price->price}}">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($price->active==1) checked @endif>
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


