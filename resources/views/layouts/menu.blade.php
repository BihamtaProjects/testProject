<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link active">
        <i class="nav-icon fas fa-home"></i>
        <p>خانه</p>
    </a>
</li>
<li class="treeview" >
    <a href="{{route('roles.index') }}" class="nav-link">
        <i class="nav-icon fas fa-user-secret"></i>
        <p>نقش ها</p>
    </a>
</li>
<li class="treeview" >
    <a href="{{ route('home') }}" class="nav-link">
        <i class="nav-icon fas fa-address-card"></i>
        <p>دسترسی ها</p>
    </a>
</li>
<li class="treeview" >
    <a href="{{route('users.index')}}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>مدیریت کاربران</p>
    </a>
</li>

<li class="treeview" >
    <a href="{{route('pages.index')}}" class="nav-link">
        <i class="nav-icon fas fa-paperclip"></i>
        <p>مدیریت صفحات</p>
    </a>
</li>

<li class="treeview" >
    <a href="{{ route('home') }}" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        <p>گزارشات</p>
    </a>
</li>
<li class="treeview" >
    <a href="{{route('services.index')}}" class="nav-link">
        <i class="nav-icon fas fa-sticky-note"></i>
        <p>مدیریت خدمات وبیناری</p>
    </a>
</li>
<li class="treeview" >
    <a href="{{ route('subjects.index') }}" class="nav-link">
        <i class="nav-icon fas fa-align-justify"></i>
        <p>مدیریت دسته بندی ها</p>
    </a>
</li>
<li class="treeview" >
    <a href="#" class="nav-link caret">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>مدیریت دوره ها و رویدادها</p>
    </a>
    <ul class="treeview-menu nested">
        <li class="treeview">
            <a href="{{ route('covents.index' ,['isEvent' => 0])}}" class="nav-link">
                <p>درس ها</p>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('covents.index',['isEvent' => 1])}}}" class="nav-link">
                <p>رویدادها</p>
            </a>
        </li>
    </ul>

</li>
<li class="treeview" >
    <a href="#" class="nav-link caret">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>مالی</p>
    </a>

<ul class="treeview-menu nested">
    <li class="treeview">
    <a href="{{ route('successPayments.index') }}" class="nav-link">
        <p>لیست پرداخت های موفق</p>
    </a>

   </li>
    <li class="treeview">
    <a href="{{ route('home') }}" class="nav-link">
        <p>پرداخت کارت به کارت</p>
    </a>

   </li>
    <li class="treeview">
    <a href="{{ route('home') }}" class="nav-link">
        <p>تراکنشات مالی کاربران</p>
    </a>

   </li>
    <li class="treeview">
    <a href="{{ route('home') }}" class="nav-link">
        <p>تراکنش های انلاین</p>
    </a>
</li>
    <li class="treeview">
        <a href="{{ route('home') }}" class="nav-link">
            <p>تایید بازگشت وجه</p>
        </a>
    </li>
</ul>

</li>
<script>
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
    });
    }
</script>
