@extends('store.head')
@section('store')
    <div class="container">
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-12">
                <div class="card" style="text-align: right;">
                    <div class="card-header">تغيير كلمة السر</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('change.password.user.store') }}">
                            @csrf

                            <input type="hidden" name="nameStore" value="{{ $name }}">
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">كلمة السر
                                    الحالية</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="current_password"
                                        autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">كلمة السر
                                    الجديدة</label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control" name="new_password"
                                        autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">تأكيد كلمة السر
                                    الجديدة</label>

                                <div class="col-md-6">
                                    <input id="new_confirm_password" type="password" class="form-control"
                                        name="new_confirm_password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4" style="margin-right: 33.3333%;">
                                    <button type="submit" class="btn btn-primary">
                                        تحديث كلمة السر
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
