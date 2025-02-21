    {!! Storage::get('stores/' . $name . '/banner.html') !!}
    {!! Storage::get('stores/' . $name . '/product.html') !!}
    {!! Storage::get('stores/' . $name . '/discount.html') !!}
    {!! Storage::get('stores/' . $name . '/blog.html') !!}
    {!! Storage::get('stores/' . $name . '/footer.html') !!}




    {{-- ----------------------- --}}


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




    {{-- هنا حق اضافة المنتجات --}}
    {{-- هنا حق اضافة المنتجات القديمة والجديده --}}
    <script>
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
            //هذا اللي فعلت له فور اتش لانه فيه كل الكاردات حق جيد وحصري
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
    </script>
    {{-- --------------------------- --}}
    {{-- هنا تحت هذا الجافا سكربت حق القالب نفسه --}}
    <script>
        {!! Storage::get('stores/' . $name . '/js/script.js') !!}
    </script>



    {{-- اكواد jquery مع اكواد ajax --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
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
                    },
                    error: function() {
                        alert('Error loading products');
                    }
                });
            });
        });
    </script>
