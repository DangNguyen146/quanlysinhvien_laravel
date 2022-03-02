@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bài tập') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="container">
                        <div class="index-tai-lieu-cover text-uppercase wow fadeInDown" data-wow-delay="0.3s">
                            <h2 class="w-100 text-center py-2 "><b>Bài tập mới nhất</b></h2>
                        </div>
                        <div class="row">
                            @each('layouts.home.post-item', $posts, 'post')
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-3">
            <div class="card">
                <div class="card-header">{{ __('Thử thách') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="container">
                        <div class="index-tai-lieu-cover text-uppercase wow fadeInDown" data-wow-delay="0.3s">
                            <h2 class="w-100 text-center py-2 "><b>Thử thách mới nhất</b></h2>
                        </div>
                        <div class="row">
                            @each('layouts.home.chall-item', $chall, 'chall')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.notifications')
@endsection