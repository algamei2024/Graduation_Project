<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="padding-right: 0px;    background: black;
    border-radius: 10px;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon rotate-n-10">
            @php
                $trader_id = auth()->guard('trader')->id();
                $storeInfo = \DB::table('store_information')->where('admin_id', $trader_id)->first();
                $logo = $storeInfo->logo;
            @endphp
            <img src="{{ asset($logo) }}" class="rounded-circle" style="width: 60px" alt="enter img for store">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt mx-2"></i>
            <span>لوحه التحكم</span>
            <span></span>

        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">

    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('file-manager') }}">

            <i class="fas fa-fw fa-chart-area"></i>
            <span>{{ trans('dashboard.media_mng') }}</span>
            <span></span>

        </a>
    </li> --}}

    {{-- تصميم المتجر --}}
    {{-- <li id="goto-react" class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-paint-brush"></i>
            <span>تصميم المتجر</span>
            <span></span>
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-paint-brush"></i>
            <span> تصميم المتجر</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"
            dir="rtl">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> تصميم المتجر
                </h6>
                <span class="collapse-item" onclick="gotoReact(this)" name="header">راس الصفحة</span>
                <span class="collapse-item" onclick="gotoReact(this)" name="banner">بطاقة العرض</span>
                <span class="collapse-item" onclick="gotoReact(this)" name="product">بطافة
                    المنتجات</span>
                <span class="collapse-item" onclick="gotoReact(this)" name="discount">بطاقة الخصم</span>
                <span class="collapse-item" onclick="gotoReact(this)" name="footer">اسفل الصفحة</span>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->is('admin/banner*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span> اعلانات المتجر</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"
            dir="rtl">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> اعلانات المتجر
                </h6>
                <a class="collapse-item" href="{{ route('banner.index') }}">الاعلانات</a>
                <a class="collapse-item" href="{{ route('banner.create') }}">اضافه اعلان</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>

    <!-- Categories -->
    <li class="nav-item {{ request()->is('admin/category*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
            <i class="fas fa-sitemap"></i>
            <span>الأصناف </span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> الأصناف</h6>
                <a class="collapse-item" href="{{ route('category.index') }}">الأصناف</a>
                <a class="collapse-item" href="{{ route('category.create') }}">اضافه صنف</a>
            </div>
        </div>
    </li>
    {{-- Products --}}
    <li class="nav-item {{ request()->is('admin/product*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="true" aria-controls="productCollapse">
            <i class="fas fa-cubes"></i>
            <span>المنتجات</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">المنتجات:</h6>
                <a class="collapse-item" href="{{ route('product.index') }}">المنتجات</a>
                <a class="collapse-item" href="{{ route('product.create') }}">اضافه منتج </a>
            </div>
        </div>
    </li>

    {{-- Brands --}}
    <li class="nav-item {{ request()->is('admin/brand*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse"
            aria-expanded="true" aria-controls="brandCollapse">
            <i class="fas fa-table"></i>
            <span>الماركه</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">خيارات الماركه :</h6>
                <a class="collapse-item" href="{{ route('brand.index') }}">الماركات</a>
                <a class="collapse-item" href="{{ route('brand.create') }}">اضافه ماركه </a>
            </div>
        </div>
    </li>

    {{-- Shipping --}}
    <li class="nav-item {{ request()->is('admin/shipping*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse"
            aria-expanded="true" aria-controls="shippingCollapse">
            <i class="fas fa-truck"></i>
            <span>الشحن</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">خيارات الشحن :</h6>
                <a class="collapse-item" href="{{ route('shipping.index') }}">الخيارات المتوفره</a>
                <a class="collapse-item" href="{{ route('shipping.create') }}">إضافة</a>
            </div>
        </div>
    </li>

    <!--Orders -->
    <li class="nav-item {{ request()->is('admin/order*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>الطلبات</span>
        </a>
    </li>

    <!-- Reviews -->
    @php
        $admin_id = auth()->guard('trader')->id();
    @endphp
    <li class="nav-item {{ request()->is('review*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rreview.index', ['admin_id' => $admin_id]) }}">
            <i class="fas fa-comments"></i>
            <span>المراجعات</span></a>
    </li>


    {{-- ////////////////////////////// --}}
    <!-- Divider -->
    {{-- <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Posts
    </div> --}}

    <!-- Posts -->
    {{-- <li class="nav-item {{ request()->is('admin/post') || request()->is('admin/post/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse"
            aria-expanded="true" aria-controls="postCollapse">
            <i class="fas fa-fw fa-folder"></i>
            <span>Posts</span>
        </a>
        <div id="postCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Post Options:</h6>
                <a class="collapse-item" href="{{ route('post.index') }}">Posts</a>
                <a class="collapse-item" href="{{ route('post.create') }}">Add Post</a>
            </div>
        </div>
    </li>

    <!-- Category -->
    <li class="nav-item {{ request()->is('admin/post-category*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse"
            aria-expanded="true" aria-controls="postCategoryCollapse">
            <i class="fas fa-sitemap fa-folder"></i>
            <span>الأصناف</span>
        </a>
        <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Options:</h6>
                <a class="collapse-item" href="{{ route('post-category.index') }}">الأصناف</a>
                <a class="collapse-item" href="{{ route('post-category.create') }}">إضافة صنف</a>
            </div>
        </div>
    </li>

    <!-- Tags -->
    <li class="nav-item {{ request()->is('admin/post-tag*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse"
            aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>Tags</span>
        </a>
        <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tag Options:</h6>
                <a class="collapse-item" href="{{ route('post-tag.index') }}">Tag</a>
                <a class="collapse-item" href="{{ route('post-tag.create') }}">Add Tag</a>
            </div>
        </div>
    </li> --}}

    {{-- ////////////////////////////////// --}}


    <!-- Comments -->
    {{-- <li class="nav-item {{ request()->is('comment') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('comment.index') }}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>التعليقات</span>
        </a>
    </li> --}}


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        الأعدادات العامة
    </div>
    <li class="nav-item {{ request()->is('admin/coupon') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('coupon.index') }}">
            <i class="fas fa-table"></i>
            <span>Coupon</span></a>
    </li>
    <!-- Users -->
    <li class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>المستخدمين</span></a>
    </li>
    <!-- General settings -->
    <li class="nav-item {{ request()->is('admin/storeIndo/update') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('updatae.storeInfo') }}">
            <i class="fas fa-cog"></i>
            <span>اعدادات المتجر</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>


<script>
    function gotoReact(event) {
        //اخذ csrf الموجودة في ملف head لارسالها مع كل رسالة طلب بيانات
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // document.querySelectorAll('.goto-react').addEventListener('click', function(event) {
        // event.preventDefault();
        const nameFile = event.getAttribute('name');
        fetch('http://127.0.0.1:8000/admin/send/data/design', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    'nameFile': nameFile
                }),
            })
            .then(response => response.json())
            .then(data => {
                // الانتقال إلى صفحة React مع البيانات المستلمة
                window.location.href = 'http://localhost:5173/goToDesigner?data=' + encodeURIComponent(
                    JSON.stringify(data));
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    }
</script>
