@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    ویرایش درس
                </div>
                <div class="card-body">
                    <form action="{{ route('covents.update',['isEvent' => 0, $course->id])}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
{{--                        @method('patch')--}}
                        <div class="form-group">
                            <label> نام </label>
                            <input class="form-control" name="title" placeholder="نام" value="{{$course->title}}">
                        </div>
                        <div class="form-group">
                            <label>عکس </label>
                            <input type="file" id="main_pic" name="main_pic">
                        </div>
                        <div class="form-group">
                            <label>ویدیو</label>
                            <input type="file" id="main_video" name="main_video">
                        </div>
                        <div class="form-group">
                            <label>مدت ویدیو</label>
                            <input class="form-control" name="video_length" placeholder="مدت ویدیو" value="{{$course->video_length}}">
                        </div>
                        <div class="form-group">
                            <label>خلاصه</label>
                            <textarea class="ckeditor form-control" name="summary" placeholder="خلاصه" >{!!$course->summary!!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>توضیحات</label>
                            <input class="ckeditor form-control" name="description" placeholder="توضیحات" value="{!!$course->description!!}">
                        </div>
                        <div class="form-group">
                            <label>پیش نیازها</label>
                            <input class="form-control" name="prerequirement" placeholder="پیش نیازها" value="{{$course->prerequirement}}">
                        </div>
                        <div class="form-group">
                            <label>مدت</label>
                            <input class="form-control" name="duration" placeholder="مدت" value="{{$course->duration}}">
                        </div>
                        <div class="form-group">
                            <label>مقیاس زمان</label>
                            <select class="form-select" name="unit_id">
                                <?php $mainunit = App\Models\Unit::where('id',$course->unit_id)->first()?>
                                <option selected>انتخاب مقیاس زمان</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}" @if($unit->id==$mainunit->id) selected @endif>{{$unit->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <?php $mainorganizer = \App\Models\Organizer::where('id',$course->organizer_id)->first();?>
                            <label>سازمان دهنده</label>
                            <select class="form-select" aria-label="سازمان دهنده" name="organizer_id">
                                <option selected>انتخاب سازمان دهنده</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{$organizer->id}}" @if($mainorganizer->id == $organizer->id) selected @endif>{{$organizer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>تاریخ شروع</label>
                            <input class="date-picker"  id="date" name="start_time">
                        </div>

                        <div class="form-group">
                            <label>اولویت</label>
                            <input class="form-control" name="priority" placeholder="اولویت" value="{{$course->priority}}">
                        </div>
                        <div class="form-group">
                            <?php $maintype = \App\Models\Type::where('id',$course->type_id)->first()?>
                            <label>نوع</label>
                            <select class="form-select" aria-label="نوع" name="type_id">
                                <option selected>انتخاب نوع</option>
                                @foreach($types as $type)
                                    <option value="{{$maintype->id}}" @if($type->id == $maintype->id) selected @endif>{{$maintype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="active" type="hidden" value="0" id="status" >
                            <input class="form-check-input" name="active" type="checkbox" value="1" id="status" @if($course->active==1) checked @endif>
                            <label class="form-check-label" for="flexCheckChecked" style="padding-right: 15px;">
                                فعال
                            </label>

                        </div>



                        <button type="submit" class="btn btn-primary">ثبت</button>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    پرسش و پاسخ ها
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="faq" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="faq-select">
                        </select>
                    </div>
                    لیست پرسش و پاسخ های دوره
                    <table class="table table-hover faq-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">سوال</th>
                            <th class="text-center">پاسخ</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($course->faqs as $faq)

                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$faq->question}}</td>
                                <td class="text-center">{{$faq->answer}}</td>
                                <td class="text-center">
                                    <a href="{{route('coventFaq.destroy',[$course->id,$faq->id])}}">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    برگزار کنندگان
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="instructor" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="instructor-select">
                        </select>
                    </div>
                    لیست برگزار کنندگان
                    <table class="table table-hover instructor-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($course->instructors as $instructor)
                            <?php $user = App\Models\User::where('id',$instructor->user_id)->first()?>
                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$user->name}}</td>
                                <td class="text-center">
                                    <a href="{{route('coventInstructor.destroy',[$course->id,$instructor->id])}}">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    لیست دسته بندی ها
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="subject-select">
                        </select>
                    </div>
                    لیست دسته بندی های دوره
                    <table class="table table-hover subject-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">دسته بندی مادر</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($course->subjects as $subject)
                            <?php if($subject->parent_id !=0){
                                $mainSubject = App\Models\Subject::where('id',$subject->parent_id)->first();
                                $mainSubject = $mainSubject->name;
                            }else{
                                $mainSubject = 'دسته اصلی';
                            }?>
                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$subject->name}}</td>
                                <td class="text-center">{{$mainSubject}}</td>
                                <td class="text-center">
                                    <a href="{{route('coventSubject.destroy',[$course->id,$subject->id])}}">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    لیست دسته بندی های منتخب
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="selected" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="selected-select">
                        </select>
                    </div>
                    لیست دسته بندی های منتخب دوره
                    <table class="table table-hover selected-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">نام صفحه</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($course->selectedgroups as $selected)

                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$selected->title}}</td>
                                <td class="text-center">{{$selected->page_name}}</td>
                                <td class="text-center">
                                    <a href="{{route('coventSelectedgroup.destroy',[$course->id,$selected->id])}}">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6"  style="padding: 20px">
            <div class="card">
                <div class="card-header" style="background-color: #7adeee">
                    لیست کلمات کلیدی
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="keyword" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="keyword-select">
                        </select>
                    </div>
                    لیست کلمات کلیدی دوره
                    <table class="table table-hover keyword-table">
                        <thead style="background-color: #9fcdff;">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row =1 ?>
                        @foreach($course->keywords as $keyword)

                            <tr class="text-center">
                                <td class="text-center">{{$row++}}</td>
                                <td class="text-center">{{$keyword->title}}</td>
                                <td class="text-center">
                                    <a href="{{route('coventKeyword.destroy',[$course->id,$keyword->id])}}">حذف</a>
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
        $('#faq').keyup(function () {
            let keyword = $(this).val();
            if (keyword.trim() != "")
                $.ajax({
                    url: "{{route("ajax.faq.search")}}",
                    data: {keyword: keyword},
                    success: function (data) {
                        let string = "";
                        string += "<option selected disabled>انتخاب کنید...</option>";
                        $.each(data, function (i, val) {
                            string += "<option  value='" + val.id + "'>" + val.question +"</option>"
                        });

                        $("#faq-select").html(string);
                    },
                    error: function(ts) { alert(ts.responseText) }
                })

        });
        $('#faq-select').change(function () {
            id = $(this).val();
            $.ajax({
                url: "{{route("ajax.covent.faq" , ['id' => $course->id])}}",
                data: {faq_id: id},
            });
            location.reload();
        });

        $('#keyword').keyup(function () {
            let keyword = $(this).val();
            if (keyword.trim() != "")
                $.ajax({
                    url: "{{route("ajax.keyword.search")}}",
                    data: {keyword: keyword},
                    success: function (data) {
                        let string = "";
                        string += "<option selected disabled>انتخاب کنید...</option>";
                        $.each(data, function (i, val) {
                            string += "<option  value='" + val.id + "'>" + val.title +"</option>"
                        });

                        $("#keyword-select").html(string);
                    },
                    error: function(ts) { alert(ts.responseText) }
                })

        });
        $('#keyword-select').change(function () {
            id = $(this).val();
            $.ajax({
                url: "{{route("ajax.covent.keyword" , ['id' => $course->id])}}",
                data: {keyword_id: id},
            });
            location.reload();
        });

        $('#subject').keyup(function () {
            let keyword = $(this).val();
            if (keyword.trim() != "")
                $.ajax({
                    url: "{{route("ajax.subject.search")}}",
                    data: {keyword: keyword},
                    success: function (data) {
                        let string = "";
                        string += "<option selected disabled>انتخاب کنید...</option>";
                        $.each(data, function (i, val) {
                            string += "<option  value='" + val.id + "'>" + val.name  +"</option>"
                        });

                        $("#subject-select").html(string);
                    },
                    error: function(ts) { alert(ts.responseText) }
                })

        });
        $('#subject-select').change(function () {
            id = $(this).val();
            $.ajax({
                url: "{{route("ajax.covent.subject" , ['id' => $course->id])}}",
                data: {subject_id: id},
            });
            location.reload();
        });

        $('#selected').keyup(function () {
            let keyword = $(this).val();
            if (keyword.trim() != "")
                $.ajax({
                    url: "{{route("ajax.selected.search")}}",
                    data: {keyword: keyword},
                    success: function (data) {
                        let string = "";
                        string += "<option selected disabled>انتخاب کنید...</option>";
                        $.each(data, function (i, val) {
                            string += "<option  value='" + val.id + "'>" + val.title + "</option>"
                        });

                        $("#selected-select").html(string);
                    },
                    error: function(ts) { alert(ts.responseText) }
                })

        });
        $('#selected-select').change(function () {
            id = $(this).val();
            $.ajax({
                url: "{{route("ajax.covent.selected" , ['id' => $course->id])}}",
                data: {selectedgroup_id: id},
            });
            location.reload();
        });

        $('#instructor').keyup(function () {
            let keyword = $(this).val();
            if (keyword.trim() != "")
                $.ajax({
                    url: "{{route("ajax.instructor.search")}}",
                    data: {keyword: keyword},
                    success: function (data) {
                        let string = "";
                        string += "<option selected disabled>انتخاب کنید...</option>";
                        $.each(data, function (i, val) {
                            string += "<option  value='" + val.id + "'>" + val.name +"</option>"
                        });

                        $("#instructor-select").html(string);
                    },
                    error: function(ts) { alert(ts.responseText) }
                })

        });
        $('#instructor-select').change(function () {
            id = $(this).val();
            $.ajax({
                url: "{{route("ajax.covent.instructor" , ['id' => $course->id])}}",
                data: {user_id: id},
            });
            location.reload();
        });

        $('.ckeditor').ckeditor();
    </script>
    <script type="text/javascript">
        var dateVar = "{{$course->start_time}}";
        jQuery.noConflict();
        jQuery(document).ready(function($){
            const myPicker = $("#date").pDatepicker({
                altField: '#dateTime',
                altFormat:'gregorian',
                observer: true,
                format: 'YYYY-MM-DD HH:MM',
                calendar:{
                    persian:{
                        locale:'en'
                    }
                }
            });
            myPicker.setDate(dateVar);

        });

    </script>


@endsection
