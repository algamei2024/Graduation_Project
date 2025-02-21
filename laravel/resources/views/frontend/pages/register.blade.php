@extends('frontend.layouts.master')

@section('title', 'IT4-project || Register Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs" style="direction: rtl">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div style="position: absolute" dir="rtl" class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('store/', ['name' => $nameStore]) }}">الرئيسية
                                    <i class="ti-arrow-left"></i>

                                </a></li>
                            <li class="active"><a href="javascript:void(0);">إنشاء حساب</a></li>
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
                    // ملاحظة : متغير namesStore هو متغير عام في ملفات blade تم تعريفه بملف AppServiceProvider

                    // $admin_id = auth()->guard('trader')->id();
                    // $namesStore[$admin_id] = auth()->guard('trader')->user()->name;
                    // $getStoreInfo = \App\Models\StoreInformation::where('admin_id', $admin_id)->first();
                    // $name = $getStoreInfo->name;

                    // // تخزين في الجلسة
                    // session()->put($admin_id, $name);

                    // echo 'مرحبا بكم في متجر' . session($admin_id);
                @endphp
            @endauth --}}
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <div style="text-align: center;margin-bottom: 20px">
                            <div> اهلا بكم في متجر</div>
                            <span style="font-size: 15px;font-weight: bold">{{ $nameStore }}</span>
                        </div>
                        <h2>إنشاء حساب</h2>
                        <p>ادخل البيانات المطلوبة لانشاء الحساب</p>
                        <!-- Form -->
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form class="form" method="post" action="{{ route('register.submit') }}">
                            @csrf
                            <input type="hidden" name="nameStore" value="{{ $nameStore }}" />
                            <input type="hidden" name="admin_id" value="{{ $admin_id }}" />
                            <div class="row">
                                <div class="col-12">
                                    <div style="text-align: right" class="form-group">
                                        <label>الاسم<span>*</span></label>
                                        <input style="text-align: right" type="text" name="name" placeholder=""
                                            required="required" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div style="text-align: right" class="col-12">
                                    <div class="form-group">
                                        <label>البريد الالكتروني<span>*</span></label>
                                        <input style="text-align: right" type="text" name="email" placeholder=""
                                            required="required" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div style="text-align: right" class="form-group">
                                        <label>كلمة السر<span>*</span></label>
                                        <input style="text-align: right" type="password" name="password" placeholder=""
                                            required="required" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div style="text-align: right" class="form-group">
                                        <label>تاكيد كلمة السر<span>*</span></label>
                                        <input style="text-align: right" type="password" name="password_confirmation"
                                            placeholder="" required="required" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div style="direction: rtl; text-align: center" class="form-group login-btn">
                                        <div
                                            style="text-align: center;
                                                    margin-bottom: 20px;">
                                            <button class="btn" type="submit">إنشاء حساب</button>
                                        </div>
                                        <a href="{{ route('login.form', ['nameStore' => $nameStore]) }}"
                                            class="btn">تسجيل الدخول</a>
                                        او
                                        <a href="{{ route('login.redirect', 'facebook') }}" class="btn btn-facebook"><i
                                                class="ti-facebook"></i></a>
                                        <a href="{{ route('login.redirect', 'github') }}" class="btn btn-github"><i
                                                class="ti-github"></i></a>
                                        <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i
                                                class="ti-google"></i></a>
                                    </div>
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
