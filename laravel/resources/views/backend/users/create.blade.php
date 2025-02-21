@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">إضافة مستخدم</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">الاسم</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}"
                        class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">البريد الالكتروني</label>
                    <input id="inputEmail" type="email" name="email" placeholder="Enter email"
                        value="{{ old('email') }}" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-form-label">كلمة السر</label>
                    <input id="inputPassword" type="password" name="password" placeholder="Enter password"
                        value="{{ old('password') }}" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- كود رفع الصورة --}}
                {{-- <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">الصورة</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ old('photo') }}">
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}



                {{-- رفع صورة بدون المكتبة --}}
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">الصورة <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" id="thumbnail" class="form-control" type="text" name="photo"
                            onchange="
                            document.getElementById('img-prod').style.display = 'inline';
                            document.getElementById('img-prod').src = window.URL.createObjectURL(this.files[0]);
                            "
                            value="{{ old('photo') }}">
                    </div>
                    <img id="img-prod" src="" alt="" style="width: 40px;height: 40px;display: none">
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {{-- كود إضافة role للمستخدم الجديد --}}
                {{-- @php
                    $roles = DB::table('users')->select('role')->get();
                @endphp --}}
                {{-- <div class="form-group">
                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-----Select Role-----</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->role }}">{{ $role->role }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}


                <div class="form-group">
                    <label for="status" class="col-form-label">الحالة</label>
                    <select name="status" class="form-control">
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">تراجع</button>
                    <button class="btn btn-success" type="submit">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
