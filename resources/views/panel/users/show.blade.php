@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    اطلاعات کاربر
                </div>
                <div class="card-body">

                    <form action="{{route('users.update',$user)}}" method="post">
                        {{csrf_field()}}
                        @method('PATCH')
                        <div class="form-group">
                            <label> نام</label>
                            <input class="form-control" name="first_name" value="{{$user->first_name }}">
                        </div>
                        <div class="form-group">
                            <label>نام خانوادگی </label>
                            <input class="form-control" name="last_name" value="{{$user->last_name }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="mobile_number">تلفن همراه</label>
                            <input type="text" class="form-control" name="mobile_number" id="mobile" value="{{$user->mobile_number}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">ایمیل</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                        </div>
                        <button type="submit" class="btn btn-primary">ثبت</button>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    نقش های کاربر
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="role" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="role-select">
                        </select>
                    </div>
                    لیست نقش های این کاربر
                    <table class="table table-hover role-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($user->roles as $role)

                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$role->name}}</td>
                                <td class="text-center">
                                    <a href="{{route('usersRole.destroy',[$user->id,$role->id])}}">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('third_party_scripts')
    <script>
$('#role').keyup(function () {
let keyword = $(this).val();
if (keyword.trim() != "")
$.ajax({
url: "{{route("ajax.role.search")}}",
data: {keyword: keyword},
success: function (data) {
let string = "";
string += "<option selected disabled>انتخاب کنید...</option>";
$.each(data, function (i, val) {
string += "<option  value='" + val.id + "'>" + val.name +"</option>"
});

$("#role-select").html(string);
},
    error: function(ts) { alert(ts.responseText) }
})

});
$('#role-select').change(function () {
id = $(this).val();
$.ajax({
url: "{{route("ajax.user.role" , ['id' => $user->id])}}",
data: {role_id: id},
});
location.reload();
});
    </script>
@endsection
