@extends('layouts.admin')
@section('title', 'Trang quản trị')
@section('customscript')
@endsection
@section('activeUsers', 'active')
@section('content')
<div class="role row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <form action="{{route('ql_users.store')}}" method="POST">
            <div class="row ms-0 me-0 w-100">
                <div class="col-md-8 ps-1 pe-1">
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">
                            <h3 class="inline">Thêm user</h3>
                        </div>
                        <div class="card-body">
                            @csrf
                            @error('username')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                            <div class="@error('username') is-invalid @enderror form-outline mb-3">
                                <input type="text" name="username" class="form-control" equired autocomplete="username"
                                    value="{{old('username')}}" />
                                <label class="form-label" for="username">User name</label>
                            </div>
                            @error('name')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                            <div class="@error('name') is-invalid @enderror form-outline mb-3">
                                <input type="text" name="name" class="form-control" equired autocomplete="name"
                                    value="{{old('name')}}" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                            @error('email')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                            <div class="@error('email') is-invalid @enderror form-outline mb-3">
                                <input type="Email" name="email" class="form-control" value="{{old('email')}}" />
                                <label class="form-label" for="email">Email</label>
                            </div>
                            @error('password')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                            <div class="@error('password') is-invalid @enderror form-outline mb-3">
                                <input type="password" name="password" class="form-control" equired
                                    autocomplete="current-password" value="{{old('password')}}" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="@error('password_confirmation') is-invalid @enderror form-outline mb-3">
                                <input type="password" name="password_confirmation" class="form-control" equired
                                    autocomplete="current-password" value="{{old('password_confirmation')}}" />
                                <label class="form-label" for="password_confirmation">Re-password</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 ps-1 pe-1">
                    <div class="card rounded-0 border-purple pb-2">
                        <div class="card-header bg-light">
                            <h5 class="inline">Chọn role</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($roles as $role)
                                <div class="form-check col-12 col-sm-6">
                                    <input type="checkbox" class="form-check-input" name="roles[]"
                                        value="{{ $role->id }}">
                                    <label class="form-check-label">{{ $role->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="px-2">
                            <button type="submit" class="btn btn-primary w-100">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection