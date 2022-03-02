@extends('layouts.admin')
@section('title', 'Quản Lý Thành Viên')
@section('customscript')
<script src="{{ asset('admin/user/index.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#table-user').DataTable();
} );
</script>
@endsection
@section('activeUsers', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 ps-1 pe-1 border-primary">
                <div class="card border-primary mb-2">
                    <div class="card-header bg-light">
                        <h3 class="inline py-2">Danh sách Thành viên</h3>
                        <a class="btn btn-primary text-right ms-5" href="{{ route('ql_users.create') }}">+ Thêm user</a>
                    </div>
                    <div class="card-body">
                        @include('admin.user.list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection