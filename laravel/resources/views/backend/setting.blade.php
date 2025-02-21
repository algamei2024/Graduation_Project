@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">إعدادات المتجر</h5>
        <div class="card-body">
            <form method="post"
                action="{{ route('updatae.storeInfo.submit', ['id' => $admin->id, 'name' => $admin->name]) }}"
                enctype="multipart/form-data">
                @csrf
                {{-- @method('PATCH') --}}
                {{-- {{dd($data)}} --}}




                @if (auth()->guard('trader')->check())
                    <div class='d-flex'>
                        <div class="card d-flex flex-column justify-center align-content-center" style="width: 18rem;">
                            <div class="card-body ">
                                <h5 class="card-title">شعارالمتجر</h5>
                                {{-- <p class="card-text">{{ $admin->storeInformation->description }}</p> --}}
                                <!-- <a href="#" class="btn btn-primary"><input type='file'  /></a>  -->
                                <!-- <img src="{{ asset($admin->storeInformation->logo) }}"  class="card-img-top" style="max-width:100px; max-height:100px"> -->
                                <div style="max-width:100px; max-height:100px">
                                    <img src="{{ asset($admin->storeInformation->logo) }}" alt="شعار المتجر" id="logo"
                                        class="card-img-top" style="max-width:100%; max-height:100%">
                                </div>

                            </div>
                            <input type="file" value="{{ old($admin->storeInformation->logo) }}" class="btn btn-primary"
                                name="logo"
                                onchange="document.getElementById('logo').src = window.URL.createObjectURL(this.files[0])">
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- ايقونه المتجر --}}
                        {{-- <div class="card d-flex flex-column justify-center align-content-center" style="width: 18rem;">
                            <div class="card-body ">
                                <h5 class="card-title">أيقونة المتجر</h5>
                                <div style="max-width:100px; max-height:100px">
                                    <img src="{{ asset($admin->storeInformation->logo) }}" alt="أيقونة المتجر"
                                        id="old_bill" class="card-img-top" style="max-width:100%; max-height:100%">
                                </div>

                            </div>

                            <input type="file" class="form-control file" name="bill" id="newbill"
                                data-filename="logo_update"
                                onchange="document.getElementById('old_bill').src = window.URL.createObjectURL(this.files[0])">
                            @error('bill')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                    </div>
                @endif




                <!-- <div class="form-group">
                <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                @error('description')
        <span class="text-danger">{{ $message }}</span>
    @enderror
                </div> -->

                <!-- <div class="form-group">
                                <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span> -->
                <!-- <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{ $data->logo }}"> -->
                <!-- <input id="thumbnail1" class="form-control" type="text" value="{{ $data->logo }}">
                                                                        </div>
                                                                        <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

                            @error('logo')
        <span class="text-danger">{{ $message }}</span>
    @enderror
                                                                                    </div> -->

                {{-- كود رفع الصورة --}}
                {{-- <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ $data->photo }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

                {{-- رفع صورة بدون المكتبة --}}
                {{-- <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">logo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" id="thumbnail" class="form-control" type="text" name="logo"
                            onchange="
                            // document.getElementById('img-prod').style.display = 'inline';
                            document.getElementById('img-prod').src = window.URL.createObjectURL(this.files[0]);
                            ">
                    </div>
                    <img id="img-prod" src="{{ asset($admin->storeInformation->logo) }}" alt=""
                        style="width: 40px;height: 40px;">
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}



                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="col-form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $admin->storeInformation->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_des" class="col-form-label">الوصف <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="quote" name="description">{{ $admin->storeInformation->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- email -->
                <!-- <div class="form-group">
                                                        <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" name="email" required value="{{ $admin->email }}">
                                                        @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror
                                                                                    </div> -->

                <!-- mobile -->
                <div class="form-group">
                    <label for="mobile" class="col-form-label">رقم المتجر <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="mobile"
                        value="{{ $admin->storeInformation->mobile }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- تقسم العنوان الى اجزاء -->
                @php
                    $content = $admin->storeInformation->location_store;

                    // أولاً، نقسم النص بناءً على الفاصلة "/"
                    $parts = explode('/', $content);

                    // ثم، نقوم بتقسيم الجزء الثاني بناءً على الفاصلة "-"
                    $secondPart = explode('-', $parts[1]);

                    // النتيجة النهائية
                    $result = [
                        $parts[0], // الجزء الأول: ibb
                        $secondPart[0], // الجزء الثاني: almashanaa
                        $secondPart[1], // الجزء الثالث: taiz street
                    ];
                @endphp

                <div class="form-group">
                    <label for="address" class="col-form-label">المدينة <span class="text-danger">*</span></label>
                    <input type="text" class="" name="address1" value="{{ $result[0] }}">
                    @error('address1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label for="address" class="col-form-label">الحي <span class="text-danger">*</span></label>
                    <input type="text" class="" name="address2" value="{{ $result[1] }}">
                    @error('address2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label for="address" class="col-form-label">الشارع <span class="text-danger">*</span></label>
                    <input type="text" class="" name="address3" value="{{ $result[2] }}">
                    @error('address3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">تعديل</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');
        $('#lfm1').filemanager('image');
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        $(document).ready(function() {
            $('#quote').summernote({
                placeholder: "Write short Quote.....",
                tabsize: 2,
                height: 100
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
