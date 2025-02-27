@extends('backend.layouts.master')
@section('title', 'E-SHOP || Banner Edit')
@section('main-content')

    <div class="card">
        <h5 class="card-header">تعديل الإعلان</h5>
        <div class="card-body">
            <form method="post" action="{{ route('banner.update', $banner->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">العنوان <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ $banner->title }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputDesc" class="col-form-label">الوصف</label>
                    <textarea class="form-control" id="description" name="description">{{ $banner->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- كود رفع الصورة --}}
                {{-- <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$banner->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}


                {{-- رفع صورة بدون المكتبة --}}
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">الصورة <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" id="thumbnail" class="form-control" type="text" name="photo"
                            onchange="
                  // document.getElementById('img-prod').style.display = 'inline';
                  document.getElementById('img-prod').src = window.URL.createObjectURL(this.files[0]);">
                    </div>
                    <img id="img-prod" src="{{ asset($banner->photo) }}" alt="" style="width: 40px;height: 40px;">
                </div>

                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


                <div class="form-group">
                    <label for="status" class="col-form-label">الحالة <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $banner->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $banner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">حفظ التعديل</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
