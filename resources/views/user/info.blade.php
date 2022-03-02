<?php
        $imgav = $user->avatar;
        $imgcover = $user->cover;
        $imgurlav = '/img/cover@1x.png';
        $imgurlcover = '/img/cover@1x.png';
        if($imgav) {
            $imgurlav ="/storage/". $imgav;
        }
        if($imgcover){
            $imgurlcover ="/storage/". $imgcover;
        }
        $imgav= $imgurlav;
        $imgcover = $imgurlcover;
?>
@extends('layouts.user')
@section('activeInfo', 'active')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css\categories.css') }}">
@endsection
@section('customscript')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/userinterface.js') }}"></script>
@endsection
@section('content')
<div class="card rounded-0 border-purple mb-5">
    <div class="card-header bg-light">Thông tin cơ bản</div>
    <div class="card-body">
        <form class="form-horizontal px-0" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{-- <div class="form-group w-100">
                @if(Auth::user()->hasRole('uiter'))
                <label for="username">Username</label>
                <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    name="username" id="username" value="{{ $user->username }}">
                @else
                <label for="username">Username <code>*Chỉ thành viên đã xác thực mới có thể đổi username</code></label>
                <input type="text" readonly disabled
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username"
                    value="{{ $user->username }}">
                @endif
            </div> --}}
            <div class="form-group mb-5">
                <label for="avatar">Ảnh cá nhân</label>
                <div class="image-upload-wrap m-2 " style="display: none;">
                    <input class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*"
                        name="imgavatar" autocompleted="">
                    <div class="drag-text">
                        <p>Kéo và thả tệp hoặc thêm hình ảnh</p>
                    </div>
                </div>
                <div class="file-upload-content over-hidden" style="display: block; height: 150px;">
                    <img class="file-upload-image h-75" src="{{ $imgurlav }}" alt="your image; ">
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="btn btn-danger">Xóa file</button>
                    </div>
                    <small id="slugHelp" class="form-text">

                    </small>
                </div>
            </div>

            <div class="form-group w-100">
                <label for="name">Tên hiển thị</label>
                <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
            </div>
            <div class="form-group w-100">
                <label for="introduce">Giới thiệu bản thân (Max. 500)</label>
                <textarea maxlength="500" rows="6"
                    class="form-control basicarea {{ $errors->has('introduce') ? 'is-invalid' : '' }}" id="introduce"
                    name="introduce">{{$user->introduce}}</textarea>
            </div>
            <div class="form-group w-100 mt-3">
                <input type="submit" class="form-control btn btn-primary btn-block" name="change_info"
                    value="Cập nhật thông tin">
            </div>
        </form>
    </div>
</div>
<div class="card rounded-0 border-purple mb-2">
    <div class="card-header">Thay đổi Email</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="email_confirm_pass">Mật khẩu hiện tại</label>
                <input type="password" class="form-control {{ $errors->has('email_confirm_pass') ? 'is-invalid' : '' }}"
                    name="email_confirm_pass" id="email_confirm_pass" value="" required>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary btn-block" name="change_email"
                    value="Thay đổi Email">
            </div>
        </form>
    </div>
</div>
<div class="card rounded-0 border-purple mb-2">
    <div class="card-header">Thay đổi mật khẩu</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="oldpass">Mật khẩu hiện tại</label>
                <input type="password" value="" class="form-control {{ $errors->has('oldpass') ? 'is-invalid' : '' }}"
                    name="oldpass" id="oldpass" required>
            </div>
            <div class="form-group">
                <label for="newpass">Mật khẩu mới</label>
                <input type="password" value="" class="form-control {{ $errors->has('confirm') ? 'is-invalid' : '' }}"
                    name="newpass" id="newpass" required>
            </div>
            <div class="form-group">
                <label for="confirm_newpass">Xác nhận Mật khẩu mới</label>
                <input type="password" value="" class="form-control {{ $errors->has('confirm') ? 'is-invalid' : '' }}"
                    name="confirm_newpass" id="confirm_newpass" required>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" name="change_pass" value="Đổi mật khẩu">
            </div>
        </form>
    </div>
</div>

@endsection