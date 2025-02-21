@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">تعديل ملف المستخدم</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">الاسم</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{ $user->name }}"
                        class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">البريد الالكتروني</label>
                    <input id="inputEmail" type="email" name="email" placeholder="Enter email"
                        value="{{ $user->email }}" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

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
                            value="{{ $user->photo }}">
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
                        //   document.getElementById('img-prod').style.display = 'inline';
                            document.getElementById('img-prod').src = window.URL.createObjectURL(this.files[0]);">
                    </div>
                    <img id="img-prod" src="{{ asset($user->photo) }}" alt="لا توجد صورة"
                        style="width: 40px;height: 40px;">
                </div>

                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


                @php
                    $roles = DB::table('users')
                        ->select('role')
                        ->where('id', $user->id)
                        ->get();
                    // dd($roles);
                @endphp
                <div class="form-group">
                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-----Select Role-----</option>
                        @foreach ($roles as $role)
                            <option value="admin" {{ $role->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $role->role == 'user' ? 'selected' : '' }}>User</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
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

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
