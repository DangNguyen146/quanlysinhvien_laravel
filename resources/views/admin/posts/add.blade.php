@extends('layouts.admin')
@section('title', 'Tạo bài Viết')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css\categories.css') }}">
@endsection
@section('customscript')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/posts.js') }}"></script>
@endsection
@section('activeBaiviet', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <form class="form-horizontal px-0" method="POST" enctype="multipart/form-data">
            <div class="row ms-0 me-0 w-100">
                <div class="col-md-8 ps-1 pe-1">
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">
                            <p class="m-0">
                                <a href="{{route('ql_baiviet.index')}}">Danh sách Bài viết</a> /
                            </p>
                            <h3 class="inline">Tạo Bài viết mới</h3>
                        </div>
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="form-outline mb-3">
                                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                                    aria-describedby="titlehelp" name="title"
                                    placeholder="vd: Tài liệu Nhập môn Mạng máy tính" onchange="textAutoLink()"
                                    required />
                                <label class="form-label" for="formtitlehelp">Tên Bài viết</label>
                            </div>
                            <div id="titlehelp" class="form-text">
                                @error('title')
                                <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Nội dung</label>
                                <textarea class="form-control summernote" name="content" id="content"
                                    rows="3"></textarea>
                                <small id="nameHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ps-1 pe-1">
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">Đề</div>
                        <div class="mb-3 @error('imgfile') is-invalid border-danger @enderror">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" id="formFile" name="stFile">
                        </div>

                        <small id="slugHelp" class="form-text"> @error('imgfile')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                        </small>
                    </div>
                    <div class="card border-primary mb-2">
                        <div class="card-body">

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="status" id="status"
                                        value="1" checked>
                                    <label class="custom-control-label" for="status">Công khai Bài viết này</label>
                                </div>
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary" name="submit">Tạo Bài
                                viết</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection