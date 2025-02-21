@extends('store.head')
@section('store')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif
    {{-- her well be return the footer --}}
    {!! Storage::get('stores/' . $name . '/header/1.html') !!}
    <div id="content-area" style='display:flex; flex-wrap:wrap; justify-content: space-evenly;'>
        <script>
            let contentCard = {!! json_encode($cardHTML) !!};

            /////
            document.querySelector('.profile-user').href = `{{ route('profile.user', ['name' => $name]) }}`;
            document.querySelector('.logout').href = `{{ route('user.logout', ['nameStore' => $name]) }}`;
            document.querySelector('.img-profile').src = `{{ asset('backend/img/avatar.png') }}`;
            document.querySelector('.login').href = `{{ route('login.form', ['nameStore' => $name]) }}`;
            document.querySelector('.register').href = `{{ route('register.form', ['nameStore' => $name]) }}`;
            document.querySelector('.change-passowrd').href = `{{ route('change.password.user', ['name' => $name]) }}`;


            function addProduct(productData) {
                let product = document.createElement('span');
                console.log(product);
                product.innerHTML = contentCard;
                product.querySelector('img').src = productData.photo;
                product.querySelector('.product_name').innerHTML = productData.title;
                product.querySelector('.product_description').innerHTML = productData.description;
                product.querySelector('._price').innerHTML = "$" + productData.price;


                let addProudct = product.querySelector('.add_to_cart');
                addProudct.textContent = "الاضافة الي السله";
                addProudct.onclick = function(e) {
                    console.log(productData.slug)
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
                let contentArea = document.getElementById('content-area');
                contentArea.appendChild(product);
            }

            // استدعاء الدالة لكل منتج
            @foreach ($products as $prod)
                addProduct({
                    photo: {!! json_encode($prod->photo) !!},
                    title: {!! json_encode($prod->title) !!},
                    description: {!! json_encode($prod->description) !!},
                    price: {!! json_encode($prod->price) !!},
                    slug: {!! json_encode($prod->slug) !!},
                });
            @endforeach
        </script>
    </div>
    <div class="mt-3 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    {{-- her is footer --}}
    {!! Storage::get('stores/' . $name . '/footer/2.html') !!}
@endsection

@push('javaScript')

    <script>
        //هنا يغير اسم المتجر بناءً على الذي بيجي من قاعة البيانات
        document.querySelector('.nameStore').textContent = {!! json_encode($name) !!};
        //هنا يعدل الشعار حسب حقه
        document.querySelector('.logo-img').src = {!! json_encode(asset($logo)) !!};
        //هنا يجيب العدد حق المنتجات المضافة الي السلة ويضيفة بجانب ايقونة السله



        let showCarts = document.querySelector('.quantity');
        showCarts.innerHTML = {!! json_encode($countCart) !!};
        //هنا عند الضغط على ايقونة السله يروح للسلة حقة
        function cartsShow() {
            window.location.pathname = '/cart';
        }
        showCarts.addEventListener('click', cartsShow);
        document.querySelector('.btn-cart').addEventListener('click', cartsShow);
    </script>

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

@endpush
