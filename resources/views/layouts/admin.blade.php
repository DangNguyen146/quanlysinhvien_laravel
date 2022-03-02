@section('libcss')
<link rel="stylesheet" href="{{ asset('css\datatables.min.css') }}">
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection
@section('customcss')
@endsection
@section('libscript')
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@include('layouts.header')
<div id="admin">
    <div class="container-fluid ps-0 pe-0" style=" min-height: 80vh;">
        <div class="row ms-0 me-0 w-100">
            @guest
            @include('layouts.notifications')
            @yield('content')
            @else
            <div class="col-12 pe-1 ps-1">
                <div class="navbar p-0 navbar-expand-lg">
                    <div class="bg-primary navbar-toggler pt-1 pb-1 mb-1 text-light" type="button"
                        data-mdb-toggle="collapse" data-mdb-target="#menuleft" aria-controls="menuleft"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars" style="width: 30px"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2 pe-1 ps-1 collapse navbar-collapse-left mt-3" id="menuleft">
                <div class="card rounded-0 mb-2 border-primary">
                    <div class="card-header ">
                        @hasanyrole('teacher')
                        <a class="list-group-item border-0 list-group-item-action rounded-0 p-0 "
                            href="/quanly">Chung</a>
                        @endhasanyrole
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            @hasanyrole('teacher')
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeSettings')"
                                href="/quanly/roles"><i class="fas fa-sliders-h fa-fw" style="width: 30px"></i> Cài
                                đặt</a>
                            @endhasanyrole
                            @hasanyrole('teacher')
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeUsers')"
                                href="/quanly/users"><i class="fas fa-users fa-fw" style="width: 30px"></i> Thành
                                viên</a>
                            @endhasanyrole
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 mb-2 border-primary">
                    <div class="card-header bg-light">
                        Quản lý
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            @hasanyrole('teacher')
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeBaiviet')"
                                href="/quanly/baiviet"><i class="fas fa-pencil-alt fa-fw" style="width: 30px"></i> Bài
                                viết/ Môn học</a>
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeChallend')"
                                href="/quanly/thuthach"><i class="fas fa-pencil-alt fa-fw" style="width: 30px"></i>Thử
                                thách</a>
                            @endhasanyrole
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-10 ps-0 pe-0 mt-3" id="menuRight">
                @include('layouts.notifications')
                @yield('content')
            </div>
            @endguest
        </div>
    </div>
</div>
@include('layouts.footer')