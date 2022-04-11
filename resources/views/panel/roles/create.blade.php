@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                   افزودن نقش
                </div>
                <div class="card-body">
                    <form action="{{route('roles.store')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="name" placeholder="نام نقش">
                        </div>
                        <div class="form-group">
                            <label>عنوان کوتاه</label>
                            <input class="form-control" name="slug" placeholder="عنوان کوتاه">
                        </div>


                        <button type="submit" class="btn btn-primary">ثبت</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

