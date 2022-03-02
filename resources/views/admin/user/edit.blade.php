@extends('layouts.admin')
@section('title', 'Quản Lý Thành Viên')
@section('customscript')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/user/edit.js') }}"></script>
@endsection
@section('activeUsers', 'active')
@section('content')
<div class="role row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-8 ps-1 pe-1">
                <div class="card rounded-0 border-purple mb-2">
                    <div class="card-header bg-light">
                        <p class="m-0">
                            <a href="{{route('ql_users.index')}}">Danh sách Thành viên</a> /
                        </p>
                        <h3 class="inline">Thông tin cơ bản: <b>{{$user->name}}</b></h3>
                    </div>
                    <div class="card-body">
                        @include('admin.user.form_user_info', ['user' =>$user])
                    </div>
                </div>
            </div>
            <div class="col-md-4 ps-1 pe-1">
                <div class="card rounded-0 border-purple mb-2">
                    <div class="card-header bg-light">
                        <h5 class="inline">Quyền</h5>
                    </div>
                    <div class="card-body">
                        @include('admin.user.form_user_role', ['user' =>$user, 'roles'=> $roles])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
