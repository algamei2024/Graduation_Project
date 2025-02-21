{{-- مع اكواد لارافل --}}
{{-- <div class="product-grid">
    @foreach ($product as $prod)
        <div class="showcase product_card pNew">

            <div class="showcase-banner">
                <img src="{{ asset($prod->photo) }}" alt="حدث خطا في عرض صورة المنتج" class="product-img default"
                    width="300">

                <div class="showcase-actions">
                    <button class="btn-action">
                        <ion-icon name="eye-outline"></ion-icon>
                    </button>
                    <button class="btn-action add_to_cart">
                        <ion-icon name="bag-add-outline"></ion-icon>
                    </button>
                </div>
            </div>

            <div class="showcase-content">
                <a href="#" class="showcase-category product_name">{!! $prod->title !!}</a>

                <h3>
                    <a href="#" class="showcase-title product_description">{!! $prod->description !!}</a>
                </h3>

                <div class="showcase-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star-outline"></ion-icon>
                    <ion-icon name="star-outline"></ion-icon>
                </div>

                <div class="price-box">
                    <p class="price _price">{!! $prod->discount !!}</p>
                </div>

            </div>

        </div>
    @endforeach
</div> --}}

{{-- بدون اكواد لارافل --}}
{{-- <div class="product-container">
    <div class="container">
        <div class="sidebar  has-scrollbar" data-mobile-menu>
            <div class="product-showcase">

                <h3 class="showcase-heading">المنتجات</h3>

                <div class="showcase-wrapper">

                    <div class="showcase-container">

                        <div class="showcase product_card pDefault">

                            <a href="#" class="showcase-img-box">
                                <img src="./assets/images/products/2.jpg" alt="men's hoodies t-shirt"
                                    class="showcase-img" width="75" height="75">
                            </a>

                            <div class="showcase-content">
                                <button class="add_to_cart">
                                    <ion-icon name="bag-add-outline"></ion-icon>
                                </button>
                                <a href="#">
                                    <h4 class="showcase-title product_name">اسم المنتج</h4>
                                </a>
                                <p class="product_description">
                                    وصف قصير
                                </p>
                                <div class="showcase-rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star-half-outline"></ion-icon>
                                </div>

                                <div class="price-box _price">
                                    <del>$17.00</del>
                                    <p class="price">$7.00</p>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div class="product-box">
            <div class="product-main">

                <h2 class="title">منتجات جديده</h2>

                <div class="product-grid">

                    <div class="showcase product_card pNew">

                        <div class="showcase-banner">
                            <img src="./assets/images/products/jacket-5.jpg" alt="MEN Yarn Fleece Full-Zip Jacket"
                                class="product-img default" width="300">
                            <img src="./assets/images/products/jacket-6.jpg" alt="MEN Yarn Fleece Full-Zip Jacket"
                                class="product-img hover" width="300">

                            <div class="showcase-actions">
                                <button class="btn-action">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </button>
                                <button class="btn-action add_to_cart">
                                    <ion-icon name="bag-add-outline"></ion-icon>
                                </button>
                            </div>
                        </div>

                        <div class="showcase-content">
                            <a href="#" class="showcase-category product_name">الاسم</a>

                            <h3>
                                <a href="#" class="showcase-title product_description">وصف قصير</a>
                            </h3>

                            <div class="showcase-rating">
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                            </div>

                            <div class="price-box">
                                <p class="price _price">$58.00</p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div> --}}

{!! Storage::get('stores/' . $name . '/product.html') !!}



{{-- هنا حق اضافة المنتجات --}}
{{-- هنا حق اضافة المنتجات القديمة والجديده --}}
{{-- <script>
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
            product.querySelector('._price').innerHTML = "$" + "<del>" + productData.price + "</del>" + "   " + "$" + (
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
        //هذا اللي فعلت له فور اتش لانه فيه كل الكاردات حق جديد وحصري
        contentCard.forEach(element => {
            if (productData.condition == "default" && element.classList.value.includes('pDefault')) {
                fillData(productData, element);
            } else if (productData.condition == "new" && element.classList.value.includes('pNew')) {
                fillData(productData, element);
            } else if (productData.condition == "hot" && element.classList.value.includes('pHot')) {
                fillData(productData, element);
            } else if (productData.discount != 0 && element.classList.value.includes('pDiscount')) {
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
</script> --}}
{{-- هنا تحت هذا الجافا سكربت حق القالب نفسه --}}
{{-- <script>
    {!! Storage::get('stores/' . $name . '/js/script.js') !!}
</script> --}}
<script>
    function initScripts() {
        let contentCard = document.querySelectorAll('.product_card');
        document.querySelector('.title').innerHTML = 'المنتجات';
        document.querySelector('.sidebar').remove();
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
                        'pNew')) {
                    fillData(productData, element);
                } else if (productData.condition == "new" && element.classList.value.includes(
                        'pNew')) {
                    fillData(productData, element);
                } else if (productData.condition == "hot" && element.classList.value.includes(
                        'pNew')) {
                    fillData(productData, element);
                } else if (productData.discount != 0 && element.classList.value.includes(
                        'pNew')) {
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
</script>
