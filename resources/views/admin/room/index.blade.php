@extends('layouts.admin')
@section('title', 'Quản lý lớp')
@section('customscript')
<script src="{{ asset('admin/user/index.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#table-category').DataTable();
} );
</script>
@endsection
@section('activeDanhmuc', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 ps-1 pe-1 border-primary">
                <div class="card border-primary mb-2">
                    <div class="card-header bg-light">
                        <h3 class="inline py-2">Quản lý lớp</h3>
                        <a class="btn btn-primary text-right ms-5" href="{{ route('ql_lop.create') }}">+ Thêm lớp
                            mới</a>
                    </div>
                    <div class="card-body">
                        <div class="container responsive">
                            <div class="row">
                                <table class="table table-bordered table-hover" id="table-category">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên lớp</th>
                                            <th scope="col">Số thành viên</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {!! Helpers::get_table_cat(0) !!} --}}
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