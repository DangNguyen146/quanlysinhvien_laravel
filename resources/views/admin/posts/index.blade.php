@extends('layouts.admin')
@section('title', 'Quản Lý bài viết')
@section('customscript')
<script src="{{ asset('admin/user/index.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#table-post').DataTable();
} );
</script>
@endsection
@section('activeBaiviet', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 ps-1 pe-1 border-primary">
                <div class="card border-primary mb-2">
                    <div class="card-header bg-light">
                        <h3 class="inline py-2">Quản Lý bài viết</h3>
                        <a class="btn btn-primary text-right ms-5" href="{{ route('ql_baiviet.create') }}">+ Thêm bài
                            viết mới</a>
                    </div>
                    <div class="card-body">
                        <div class="container responsive">
                            <div class="row">
                                <table class="table table-bordered table-hover" id="table-post">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">Tên bài viết</th>
                                            <th scope="col">Quản lý bởi</th>

                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Hiển thị với</th>
                                            <th scope="col">Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($posts) > 0)
                                        @foreach ($posts as $post)
                                        <tr>
                                            <th scope="row">
                                                <a href="/quanly/baiviet/show/{{ $post->id }}">{{ $post->title }}</a>
                                                <a href="/quanly/baiviet/edit/{{ $post->id }}"
                                                    class="ms-1 badge badge-success badge-hidden">Chỉnh sửa</a>

                                            </th>
                                            <td>
                                                <?php
                                                $postUser = App\Models\User::find($post->idUser);
                                                echo '<a href="/u/'.$postUser->username.'" target="_blank">'.$postUser->name.'</a>';
                                              ?>
                                            </td>
                                            <td>{{Helpers::count_file($post->id)}}</td>

                                            <td>@if($post->status == 1) <span class="text-success">Công khai</span>
                                                @else <span class="text-danger">Đang ẩn</span> @endif</td>

                                            <td><span data-toggle="tooltip"
                                                    title="Chỉnh sửa lần cuối lúc {{ date('H:i:s - d/m/Y', strtotime($post->updated_at)) }}">{{
                                                    date('d/m/Y', strtotime($post->updated_at)) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <tr>
                                            <td colspan="7">Chưa có bài viết!</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection