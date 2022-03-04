@extends('layouts.admin')
@section('title', 'Trang quản trị')
@section('customscript')
@endsection
@section('activeSettings', 'active')
@section('content')
<div class="role row ms-0 me-0 w-100">
    <div class="col-md-12 container-fluid">
        <div class="row ms-0 me-0 w-100">
            <div class="col-md-12 border-primary">
                <form action="{{route('ql_roles.store')}}" method="POST" enctype="multipart/form-data">
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">
                            <h4>Quản lý phân quyền</h4>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="form-outline col-md-4">
                                    <input type="text" name="name"
                                        class="@error('name') is-invalid @enderror form-control" />
                                    <label class="form-label" for="name">Nhập role</label>
                                    @error('name')
                                    <div class="text-danger p-0">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-outline col-md-4 ms-2">
                                    <input type="text" class="form-control mb-0" name="description" id="description"
                                        aria-describedby="descriptionHelp">
                                    <label class="form-label" for="form1">Mô tả. vd: Chỉ uiter được xem</label>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                                <div class="form-group mt-3 mb-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status"
                                            value="1" checked>
                                        <label class="custom-control-label" for="status">Công khai Role này</label>
                                        <span class=" text-danger mb-0">* Chỉ uiter, user và những role mới tạo mới có
                                            thể công khai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">
                            <h3 class="inline">Danh sách Role</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="form-check col-12 col-sm-6 col-md-3">
                                        <input type="checkbox" class="form-check-input" name="permissions[]"
                                            value="{{ $permission->id }}">
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection