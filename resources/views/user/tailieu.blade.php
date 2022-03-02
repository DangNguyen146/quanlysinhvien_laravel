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
@section('activeDanhmuc', 'active')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css\categories.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
@endsection
@section('customscript')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/userinterface.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#table-file').DataTable();
} );
</script>
@endsection
@section('content')
<div class="card rounded-0 border-purple mb-2">
    @if(Auth::check() && Auth::user()->username == $user->username)
    <div class="card-header bg-light">Tài liệu đã đóng góp</div>
    <div class="card-body">
        <div class="container responsive">
            <table id="table-file" class="table table-bordered table-hover ">
                <thead class="thead-primary">
                    <tr>
                        <th scope="col">Tên tài liệu</th>
                        <th scope="col">Bài viết</th>
                        <th scope="col">Loại tài liệu</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($files) > 0)
                    @foreach ($files as $file)
                    <tr>
                        <?php
                        $post = App\Models\Posts::find($file->idPost);
                        $u = App\Models\User::find($file->idUser);//$file->user;
                        $type = App\Models\Types::find($file->idType);//$file->type;
                        if($post) {
                        	$cat = $post->category;
                        }
                    ?>
                        <th>
                            <a target="_blank" data-toggle="tooltip" title="Xem trên Drive"
                                href="https://drive.google.com/file/d/{{ $file->idDrive }}/view">{{ $file->title }}</a>
                        </th>

                        <td>
                            @if($post)
                            <a target="_blank" href="">{{$post->title}}</a>
                            @endif
                        </td>
                        <td>
                            @if($type)
                            {{$type->name}}
                            @endif
                        </td>
                        <td>
                            @if($post)
                            @if($cat)
                            <a target="_blank"
                                href="/{{Helpers::get_setting('urlcat')}}/{{$cat->slug}}">{{$cat->name}}</a>
                            @endif
                            @endif
                        </td>
                        <td>@if($file->status == 1 || $file->status == 2) <span class="text-success">Công khai</span>
                            @elseif($file->status == 0) <span class="text-danger">Đang ẩn</span> @else<span
                                class="text-warning">Chờ duyệt</span> @endif</td>
                        <td>
                            <span data-toggle="tooltip"
                                title="Chỉnh sửa lần cuối lúc {{ date('H:i:s - d/m/Y', strtotime($file->updated_at)) }}">{{
                                date('d/m/Y', strtotime($file->updated_at)) }}</span>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">Chưa có Tài liệu!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@endsection