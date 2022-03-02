@extends('layouts.admin')
@section('title', $post->title)
@section('customscript')
<script src="{{ asset('js/category/show.js') }}"></script>
@endsection
@section('activeBaiviet', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 ps-1 pe-1 border-primary">
                <div class="card border-primary mb-2">
                    <div class="card-header bg-light">
                        <nav class="p-0 justify-content-between">
                            <div class="title-card">
                                <h3 class="inline">{{$post->title}}</h3>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-mdb-toggle="dropdown"
                                    aria-expanded="false">
                                    Tác vụ
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('ql_baiviet.edit', ['id'=>$post->id]) }}"><i
                                                class="fa fa-edit me-1"></i>
                                            Chỉnh sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" data-mdb-toggle="modal"
                                            data-mdb-target="#deleteModal"><i class="fa fa-trash me-2"></i>Xóa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="card-body">
                        <?php $newfiles = App\Models\Files::where('idPost', $post->id)->get(); ?>
                        <div class="tai-lieu row">
                            @each('layouts.admin.file', $newfiles, 'file')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog mt-5 pt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Cảnh báo</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Hành động XÓA này sẽ không thể hoàn tác!<br>
                        Tất cả <strong>Bài viết</strong> và <strong>Danh mục con</strong> nằm
                        trong
                        danh mục
                        <strong>{{ $post->name }}</strong> sẽ được chuyển qua danh mục
                        <strong>Chưa
                            phân
                            loại</strong>!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                        <a class="btn btn-danger" type="button"
                            href="{{ route('ql_baiviet.delete', ['id'=>$post->id]) }}"><i class="fa fa-trash me-2"></i>
                            Xóa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection