@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    افزودن قیمت
                </div>
                <div class="card-body">

                    <form action="{{route('price.store',$plan->id)}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label>مدت </label>
                            <input class="form-control" name="duration" placeholder="مدت">
                        </div>
                        <div class="form-group">
                            <label> تعداد روزهای رایگان </label>
                            <input class="form-control" name="freeday" placeholder="تعداد روزهای رایگان ">
                        </div>
                        <div class="form-group">
                            <label>قیمت</label>
                            <input class="form-control" name="price" placeholder="قیمت">
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


