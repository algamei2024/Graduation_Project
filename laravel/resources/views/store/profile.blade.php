@extends('store.head')
@section('store')
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h4 class=" font-weight-bold">Profile</h4>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="image">
                            @if ($profile->photo)
                                <img id="img-profile" class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:80px;width:80px;margin:auto;"
                                    src="{{ $profile->photo }}" alt="profile picture">
                            @else
                                <img id="img-profile" class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:80px;width:80px;margin:auto;"
                                    src="{{ asset('backend/img/avatar.png') }}" alt="profile picture">
                            @endif
                        </div>
                        <div class="card-body mt-4 ml-2">
                            <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{ $profile->name }}</small>
                            </h5>
                            <p class="card-text text-left"><small><i class="fas fa-envelope"></i>
                                    {{ $profile->email }}</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form class="border px-4 pt-2 pb-3" method="POST" action="{{ route('profile.user.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $profile->id }}">
                        <input type="hidden" name="nameStore" value="{{ $name }}">

                        <div class="form-group">
                            <label for="inputTitle" class="col-form-label">Name</label>
                            <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                                value="{{ $profile->name }}" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-form-label">Email</label>
                            <input id="inputEmail" type="email" name="email" placeholder="Enter email"
                                value="{{ $profile->email }}" class="form-control">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="inputPhoto" class="col-form-label">Photo</label>
                            </div>
                            <input type="file" id="inputPhoto" value="{{ $profile->photo }}" class="btn btn-primary"
                                name="profile-img"
                                onchange="document.getElementById('img-profile').src = window.URL.createObjectURL(this.files[0])">
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('javaScript')
    <style>
        .breadcrumbs {
            list-style: none;
        }

        .breadcrumbs li {
            float: left;
            margin-right: 10px;
        }

        .breadcrumbs li a:hover {
            text-decoration: none;
        }

        .breadcrumbs li .active {
            color: red;
        }

        .breadcrumbs li+li:before {
            content: "/\00a0";
        }

        .image {
            background: url('{{ asset('backend/img/background.jpg') }}');
            height: 150px;
            background-position: center;
            background-attachment: cover;
            position: relative;
        }

        .image img {
            position: absolute;
            top: 55%;
            left: 35%;
            margin-top: 30%;
        }

        i {
            font-size: 14px;
            padding-right: 8px;
        }
    </style>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
