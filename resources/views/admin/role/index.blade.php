@extends('layouts.admin')
@section('title', 'Trang quản trị')
@section('customscript')
<script src="{{ asset('js/role/index.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#table-file').DataTable();
    });
</script>
@endsection
@section('activeSettings', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 ps-1 pe-1 border-primary">
                <div class="card border-primary mb-2">
                    <div class="card-header bg-light">
                        <h3 class="inline py-2">Role user</h3>
                        <a class="btn btn-primary text-right ms-5" href="{{ route('ql_roles.create') }}">+ Thêm role</a>
                    </div>
                    <div class="card-body">
                        <div class="container responsive">
                            <div class="row">
                                <table id="table-file" class="table table-bordered table-hover">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listRole as $role)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('ql_roles.edit', ['id'=>$role->id]) }}"><i class="fa fa-edit me-2"></i>Chính sửa</a>
                                                <a class="btn btn-danger " data-mdb-toggle="modal"
                                                    data-mdb-target="#deleteModal"><i class="fa fa-trash me-2"></i>Xóa</a>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                        <strong>{{ $role->name }}</strong> sẽ được chuyển qua danh mục
                        <strong>Chưa
                            phân
                            loại</strong>!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times me-2"></i>Hủy</button>
                        <a class="btn btn-danger" type="button"
                            href="{{ route('ql_roles.delete', ['id'=>$role->id]) }}"><i class="fa fa-trash me-2"></i>
                            Xóa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection