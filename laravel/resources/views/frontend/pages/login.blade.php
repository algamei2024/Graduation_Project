@extends('frontend.layouts.master')

@section('title', 'IT4-project || Login Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs" dir="rtl">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div style="position: absolute" dir="rtl" class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('store/', ['name' => $nameStore]) }}"> الرئيسية
                                    <i class="ti-arrow-left"></i>
                                </a>
                            </li>
                            <li class="active"><a href="javascript:void(0);">تسجيل الدخول</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Breadcrumbs -->



    <!-- Shop Login -->
    <section class="shop login section" dir="ltr">
        <div class="container">
            {{-- @auth('trader')
                @php
                    $admin_id = auth()->guard('trader')->id();
                    $name = session()->get($admin_id);
                    echo 'مرحبا بكم في متجر' . $name;
                @endphp
            @endauth --}}

            {{-- //عرض جميع الاخطاء --}}
            {{-- @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <div style="text-align: center;margin-bottom: 20px">
                            <div> اهلا بكم في متجر</div>
                            <span style="font-size: 15px;font-weight: bold">{{ $nameStore }}</span>
                        </div>
                        <h2>تسجيل الدخول</h2>
                        <p>قم بتعبئة البيانات المطلوبة لتسجيل الدخول</p>
                        <!-- Form -->

                        <form class="form" method="post" action="{{ route('login.submit') }}">
                            @csrf
                            <input type="hidden" name="nameStore" value="{{ $nameStore }}" />
                            <input type="hidden" name="admin_id" value="{{ $admin_id }}" />

                            <div class="row">
                                <div class="col-12">
                                    <div style="text-align: right" class="form-group">
                                        <label>البريد الالكتروني<span>*</span></label>
                                        <input style="text-align: right" type="email" name="email" placeholder=""
                                            required="required" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div style="text-align: right" class="col-12">
                                    <div class="form-group">
                                        <label>كلمة السر<span>*</span></label>
                                        <input style="text-align: right" type="password" name="password" placeholder=""
                                            required="required" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div dir="rtl" style="text-align: center" class="form-group login-btn">
                                        <div
                                            style="text-align: center;
                                                    margin-bottom: 20px;">
                                            <button class="btn" type="submit">تسجيل الدخول
                                            </button>
                                            {{-- <span class="checkbox">
                                                <label class="checkbox-inline" for="2"><input name="news"
                                                        id="2" type="checkbox">تذكرني</label>
                                            </span> --}}
                                        </div>
                                        <a href="{{ route('register.form', ['nameStore' => $nameStore]) }}"
                                            class="btn">إنشاء حساب</a>
                                        او
                                        <a href="{{ route('login.redirect', 'facebook') }}" class="btn btn-facebook"><i
                                                class="ti-facebook"></i></a>
                                        <a href="{{ route('login.redirect', 'github') }}" class="btn btn-github"><i
                                                class="ti-github"></i></a>
                                        <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i
                                                class="ti-google"></i></a>

                                    </div>

                                    {{-- @if (Route::has('password.request'))
                                        <a class="lost-pass" href="{{ route('password.reset') }}">
                                            نسيت كلمة السر ؟
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection
@push('styles')
    <style>
        .shop.login .form .btn {
            margin-right: 0;
        }

        .btn-facebook {
            background: #39579A;
        }

        .btn-facebook:hover {
            background: #073088 !important;
        }

        .btn-github {
            background: #444444;
            color: white;
        }

        .btn-github:hover {
            background: black !important;
        }

        .btn-google {
            background: #ea4335;
            color: white;
        }

        .btn-google:hover {
            background: rgb(243, 26, 26) !important;
        }
    </style>
@endpush
