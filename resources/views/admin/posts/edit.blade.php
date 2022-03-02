@extends('layouts.admin')
@section('title', $post->title.' - Chỉnh sửa bài Viết')
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
                                <a href="{{route('ql_baiviet.show', $post->id)}}">{{$post->title}}</a> /
                            </p>
                            <h3 class="inline">Chỉnh sửa Bài viết</h3>
                        </div>
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Tên Bài viết</label>
                                <input type="text" value="{{$post->title}}" class="form-control is-valid edit"
                                    name="title" id="title" aria-describedby="titleHelp"
                                    placeholder="vd: Tài liệu Nhập môn Mạng máy tính" idPost="{{ $post->id }}" required>
                                <small id="titleHelp" class="form-text"></small>
                            </div>

                            <div class="form-group">
                                <label for="content">Nội dung</label>
                                <textarea class="form-control summernote" name="content" id="content"
                                    rows="3">{{$post->content}}</textarea>
                                <small id="nameHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ps-1 pe-1">
                    <div class="mb-2 card border-primary mb-2">
                        <div class="card-header bg-light">Đề</div>
                        <div class="mb-3 @error('imgfile') is-invalid border-danger @enderror">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" id="formFile" name="stFile" />
                            <a href="/storage/{{$idStfile->name}}">{{$idStfile->name}}</a>
                        </div>

                        <small id="slugHelp" class="form-text"> @error('imgfile')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                        </small>

                        <div class="card-header bg-light">Đề</div>
                        <div class="image-upload-wrap m-2 @error('imgfile') is-invalid @enderror"
                            style="display: none;">
                            <input class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*"
                                name="stFile" autocompleted="">
                            <div class="drag-text">
                                <p>Kéo và thả tệp hoặc thêm hình ảnh</p>
                            </div>
                        </div>

                    </div>


                    <div class="card border-primary mb-2">
                        <div class="card-body">

                            <div class="form-group">
                                <label class="form-check-label">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status"
                                            value="1" {{ ($post->status == 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Công khai Bài viết này</label>
                                    </div>
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary" name="submit">Cập nhật</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal">Xóa</button>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog mt-5 pt-5" role="document">
                            <div class="modal-content border-danger">
                                <div class="modal-header bg-danger text-light">
                                    <h5 class="modal-title" id="deleteModalLabel">CẢNH BÁO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Hành động XÓA này sẽ không thể hoàn tác!<br>
                                    Tất cả <strong>Tài liệu</strong> nằm trong Bài viết
                                    <strong>{{ $post->title }}</strong> sẽ được chuyển qua <strong>Thùng rác</strong>!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <button type="button" id="deleteBaiviet" name="delete" class="btn btn-danger"><i
                                            class="fa fa-trash pe-1"></i>Xóa Bài viết</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection