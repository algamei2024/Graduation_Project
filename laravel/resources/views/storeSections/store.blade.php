<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name }}</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        {!! Storage::get('stores/' . $name . '/css/style-prefix.css') !!}
    </style>
    <style>
        .footer-nav .nav-title::before {
            right: 0;
        }
    </style>

</head>

<body dir="rtl">
    {!! Storage::get('stores/' . $name . '/header.html') !!}
    <div id="product-list" class="container mt-4">
        {!! Storage::get('stores/' . $name . '/banner.html') !!}
        {!! Storage::get('stores/' . $name . '/product.html') !!}
        {!! Storage::get('stores/' . $name . '/discount.html') !!}
        {!! Storage::get('stores/' . $name . '/blog.html') !!}
        {!! Storage::get('stores/' . $name . '/footer.html') !!}
    </div>
</body>


</html>




{{-- ----------------------- --}}
<script>
    try {
        //اسم المتجر
        let nameStore = document.querySelector('.nameStore');
        if (nameStore) {
            nameStore.textContent = {!! json_encode($name) !!};
        }
        //شعار المتجر
        document.querySelector('.logo-img').src = {!! json_encode(asset($logo)) !!};

        // صورة الغلاف الشخصي الافتراضية
        document.querySelector('.img-profile').src = `{{ asset('backend/img/avatar.png') }}`;

        document.querySelector('.profile-user').href = `{{ route('profile.user', ['name' => $name]) }}`;
        document.querySelector('.logout').href = `{{ route('user.logout', ['nameStore' => $name]) }}`;
        document.querySelector('.login').href = `{{ route('login.form', ['nameStore' => $name]) }}`;
        document.querySelector('.register').href = `{{ route('register.form', ['nameStore' => $name]) }}`;
        document.querySelector('.change-passowrd').href = `{{ route('change.password.user', ['name' => $name]) }}`;

        //هنا يجيب العدد حق المنتجات المضافة الي السلة ويضيفة بجانب ايقونة السله
        let showCarts = document.querySelector('.btn-cart .quantity');
        showCarts.innerHTML = {!! json_encode($countCart) !!};
        //هنا عند الضغط على ايقونة السله يروح للسلة حقة
        function cartsShow() {
            window.location.pathname = '/cart';
        }
        showCarts.addEventListener('click', cartsShow);
        document.querySelector('.btn-cart').addEventListener('click', cartsShow);
    } catch (Ex) {}
</script>

{{-- هنا كان الاصناف اللي فوق --}}
<script>
    try {
        //هنا ul حق الاصناف
        let ulCategory = document.querySelector('.ul-category');
        //هنا  نسخت واحده من li
        //لانه قد ربما فاعل تنسيقات على li واللي داخله
        let childLi = ulCategory.querySelector('li');
        //فضيتها
        ulCategory.innerHTML = '';
        //هنا البيانات الاصناف من قاعدة البيانات
        let dataCat = {!! json_encode($cat) !!};
        //هنا عملت عناصر html عشان ارجع انسخ منهن
        ul = document.createElement('ul');


        /////
        var namestore = @json($name); //ارسال اسم المتجر 
        // var namestore = "wajdi";
        if (childLi.querySelector('a')) {
            // childLi.querySelector('a').classList.add('nav-link');
            // childLi.querySelector('a').setAttribute('data-category', "الرئيسية");
            // childLi.querySelector('a').setAttribute('data-namestore', namestore);
            childLi.querySelector('a').href = `{{ route('home.store', ['name' => $name]) }}`;

        } else {
            //هنا افعله وسم a لانه مافيش معه
            childLi.innerHTML =
                // `<a class="nav-link" data-category="الرئيسية" data-namestore='${namestore}' >  
                //         الرئيسية
                // </a>`;
                `<a href="{{ route('home.store', ['name' => $name]) }}" >  
                        الرئيسية
                </a>`;
        }


        ulCategory.appendChild(childLi);
        //////

        //=================================
        //هنا اخليه يدور على الاصناف
        dataCat.forEach(element => {
            //هنا نسخت عنصر li لانه اكيد راح اضيفه كصنف
            copyLi = childLi.cloneNode(true);
            //اتحقق اذا العنصر روت 
            //هنا افحص انه معه وسم a 
            //عشان ا فعله رابط يروح يجيب حسب الصنف
            if (copyLi.querySelector('a')) {
                copyLi.querySelector('a').innerHTML = `${element.title}`;
                copyLi.querySelector('a').classList.add('nav-link');
                copyLi.querySelector('a').setAttribute('data-category', element.id);
                copyLi.querySelector('a').setAttribute('data-namestore', namestore);
                // copyLi.querySelector('a').href ="{!! route('list.category', ['id' => '2', 'name' => $name, 'category' => 'temp']) !!}"
                // .replace('temp', element.id);
            } else {
                //هنا افعله وسم a لانه مافيش معه
                copyLi.innerHTML =
                    `<a class="nav-link" data-category="${element.id}"  data-namestore='${namestore}' >${element.title}</a>`;
            }
            if (element.parent_id == null) {
                //هنا تاكدت ان العنصر روت لذلك اضيفه الي
                // li الرئيسية لانه صنف اساسي روت
                copyLi.setAttribute('data-key', element.id);
                ulCategory.appendChild(copyLi);
            } else {
                //هنا تاكدت ان الصنف مو اساسي لذلك اضيف كابن
                //هنا تحت الاب الاساسي للصنف الابن
                let childUl = ulCategory.querySelector(`[data-key='${element.parent_id}']`);
                // هنا اذا الصنف الاساسي ما معه داخل ul افعله
                if (childUl.children.length < 2) {
                    //هنا اضيف ul لانه الصنف الرئيسي معه اصناف فرعية
                    copyUl = ul.cloneNode(true);
                    //اضيف ul الصنف الرئيسي
                    childUl.appendChild(copyUl);
                }
                // هنا اضيف العنصر ل ul حق الاب
                //الطريقة الاولى لاضافة Li الي ul وهي الافضل
                childUl.querySelector('ul').appendChild(copyLi);
                //الطريقة الثانيه في اضافة Li الي داخل ul
                //childUl.children[1].appendChild(copyLi); 
            }
        });
    } catch (Ex) {}
</script>
{{-- ------------------------------- --}}


{{-- حق الاعلانات --}}
<script>
    let Containerbanner = document.querySelector('.carousel-inner');
    // let banner = Containerbanner.querySelector('.carousel-item');
    Containerbanner.innerHTML = '';
    let dataBanner = '';
    let test = true;
</script>

@if ($dataB->count() > 0)
    @foreach ($dataB as $data)
        <script>
            function setBanner() {

                // let copybanner = banner.cloneNode(true);
                // copybanner.querySelector('.banner-img').src = {!! json_encode($data->photo) !!};
                // copybanner.querySelector('.banner-title').innerHTML = {!! json_encode($data->title) !!};
                // copybanner.querySelector('.banner-subtitle').innerHTML = {!! json_encode($data->description) !!};
                // Containerbanner.appendChild(copybanner);
                if (test) {
                    dataBanner = `
                            <div class="carousel-item active" style="height:20rem">
                                    <img src="{{ asset($data->photo) }}"  
                                        class="d-block  banner-img" alt="..." style="width:80%;height:20rem;right:10%;position:relative">
                                <div class="banner-content">

                                    <p class="banner-subtitle">{!! $data->title !!}</p>

                                    <h2 class="banner-title">{!! $data->description !!}</h2>
                                    <a href="#" class="banner-btn">تسوق الان</a>
                            </div>
                            </div>
                `;
                    test = false;
                } else {
                    dataBanner = `
                            <div class="carousel-item" style="height:20rem" >
                                        <img src="{{ asset($data->photo) }}" 
                                        class="d-block  banner-img" alt="..." style="width:80%;height:20rem;right:10%;position:relative"> 
                                        
                                    <div class="banner-content">

                                    <p class="banner-subtitle">{!! $data->title !!}</p>

                                    <h2 class="banner-title">{!! $data->description !!}</h2>
                                    <a href="#" class="banner-btn">تسوق الان</a>
                            </div>
                            </div>
                `;
                }
                Containerbanner.innerHTML += dataBanner;
            }
            setBanner();
        </script>
    @endforeach
@else
    <style>
        .no-banner {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .no-banner-child {
            font-size: 20px;
            font-weight: bold;
            color: red;
        }
    </style>
    <script>
        Containerbanner.innerHTML = '<div class="no-banner"><div class="no-banner-child">لا يوجد إعلانات حاليا</div></div>';
    </script>
@endif


<script>
    {!! Storage::get('stores/' . $name . '/js/script.js') !!}
</script>



{{-- //// --}}
@if (!Auth::check())
    {
    <script>
        document.querySelector('.btn-cart').remove();
        document.querySelector('.profile').remove();
    </script>
    }
@else
    {
    {{-- حذف ازرار تسجيل الدخول وانشاء حساب بعد تسحيل الدخول --}}
    <script>
        document.querySelector('.log-reg').remove();
    </script>
    @if (!empty(Auth::user()->photo))
        {
        <script>
            document.querySelector('.img-profile').src = {!! json_encode(Auth::user()->photo) !!};
        </script>
        }
    @endif
    <script>
        document.querySelector('.name-user').textContent = {!! json_encode(Auth::user()->name) !!};
    </script>
    }
@endif


{{-- اكواد jquery مع اكواد ajax --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        function initScripts() {
            let contentCard = document.querySelectorAll('.product_card');
            //الداله هذه تشتغل حسب الشرط
            //يعني تدخل تعبي كل وحده حسب حقها مثل جديد حصري
            function fillData(productData, element) {
                let product = element.cloneNode(true);
                product.querySelector('a').href = `{{ route('product-detail', '') }}/${productData.slug}`;
                let imgs = product.querySelectorAll('img');
                imgs[0].src = productData.photo;
                if (imgs.length > 1)
                    imgs[1].src = productData.photo;
                product.querySelector('.product_name').innerHTML = productData.title;
                product.querySelector('.product_description').innerHTML = productData.summary;
                if (productData.discount != 0) {
                    product.querySelector('._price').innerHTML = "$" + "<del>" + productData.price + "</del>" +
                        "   " + "$" + (
                            productData.price - ((productData.price * productData.discount) / 100));
                } else {
                    product.querySelector('._price').innerHTML = "$" + productData.price;
                }
                let addProduct = product.querySelector('.add_to_cart');
                if (addProduct)
                    addProduct.onclick = function(e) {
                        let name = {!! json_encode($name) !!};
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action =
                            `{{ route('single-add-to-cart', ['slug' => '']) }}${productData.slug}&quant='1'&nameStore=${name}`;
                        // مسار الإضافة إلى السلة

                        // إضافة CSRF token
                        let csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = '{{ csrf_token() }}';
                        form.appendChild(csrfField);
                        e.target.appendChild(form);
                        form.submit();
                    }
                let contentArea = element.parentNode;
                contentArea.appendChild(product);
            }

            function addProduct(productData) {
                //هذا اللي فعلت له فور اتش لانه فيه كل الكاردات حق جيد وحصري
                contentCard.forEach(element => {
                    if (productData.condition == "default" && element.classList.value.includes(
                            'pDefault')) {
                        fillData(productData, element);
                    } else if (productData.condition == "new" && element.classList.value.includes(
                            'pNew')) {
                        fillData(productData, element);
                    } else if (productData.condition == "hot" && element.classList.value.includes(
                            'pHot')) {
                        fillData(productData, element);
                    } else if (productData.discount != 0 && element.classList.value.includes(
                            'pDiscount')) {
                        fillData(productData, element);
                    }
                })
            }

            // استدعاء الدالة لكل منتج
            @foreach ($products as $prod)
                addProduct({
                    photo: {!! json_encode($prod->photo) !!},
                    title: {!! json_encode($prod->title) !!},
                    summary: {!! json_encode($prod->summary) !!},
                    price: {!! json_encode($prod->price) !!},
                    slug: {!! json_encode($prod->slug) !!},
                    condition: {!! json_encode($prod->condition) !!},
                    discount: {!! json_encode($prod->discount) !!},
                });
            @endforeach
            //انا اخذت من الكارد الاصليه فوق
            //وجالس اضيف نسخ منها وهي بالاصل النسخه الاصليه موجوده
            //النسخه الاصليه موجوده بالصفحه والحين احذفها
            contentCard.forEach(element => {
                element.remove();
            });

        }

        initScripts();
        console.log('===========================');
        $('.nav-link').on('click', function(e) {
            e.preventDefault();
            var category = $(this).data('category');
            var name = $(this).data('namestore');

            console.log('====== the name is ', name);
            console.log('====== the category is ', category);

            $.ajax({
                url: '/list/category/' + name + '/' + category,
                method: 'GET',
                success: function(data) {
                    $('#product-list').html(data);
                    // initScripts();
                },
                error: function() {
                    alert('Error loading products');
                }
            });
        });
    });
</script>
