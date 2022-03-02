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
@section('customcss')
<link href="{{ asset('css/item.css') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection
@section('title', $user->name . ' | Kho tài liệu số')
@section('searchbox')
<div class="cover container-fluid p-0 cover">
    <div class="backgoudcover" style="background-image: url({{ $imgcover }});"></div>
    <div class="avatar">
        <div class="container text-center" style="transform: translateY(-25%)">
            <div class="avatar bg-white mx-auto over-hidden" style="width:150px; height:150px">
                <img class="h-100 text-center" src="{{ $imgav }}" alt="avatar">
            </div>
            <div class="avatar-content ">
                <a href="" class="fw-bold">
                    <h1>{{$user->name}}</h1>
                </a>
                <div class="row">
                    <div class="col"></div>
                    @if(strlen($user->introduce)!=0)
                    <div class="col-10 col-md-6 bg-white p-2 ">
                        {!! $user->introduce !!}
                    </div>
                    @endif
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layouts.header')
<div class="user">
    <div class="container" style="min-height: 60vh;">
        <div class="row">
            @if(Auth::check() && Auth::user()->username == $user->username)
            <div class="col-md-3">
                <div class="card rounded-0 mb-2">
                    <div class="card-header bg-light">
                        Quản Trị
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeInfo')"
                                href="/u/{{$user->username}}/thongtin"><i class="fas fa-info fa-fw"
                                    style="width: 20px"></i> Thông tin cá
                                nhân</a>
                            <a class="list-group-item border-0 list-group-item-action rounded-0 @yield('activeDanhmuc')"
                                href="/u/{{$user->username}}/tailieucuaban"><i class="fas fa-folder fa-fw"
                                    style="width: 20px"></i> Tài liệu của bạn</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @include('layouts.notifications')
                @yield('content')
            </div>
            @else
            <div class="col-md-12 mb-5">
                @include('layouts.notifications')
                @yield('content')
            </div>
            @endif
        </div>
    </div>
</div>
@include('layouts.footer')