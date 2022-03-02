@extends('layouts.user')
@section('activeIndex', 'active')
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
<div class="card-header bg-light ">Để lại lời nhắn</div>
<form class="form px-2" method="POST" enctype="multipart/form-data" action="{{route('loinhan', $user->id)}}">
    <div class="form-row pt-3 pb-2 ps-3 w-100">
        {{ csrf_field() }}
        @isset($mess)
        <div class="row pb-3 ms-1">
            <div class="form-outline col-md-4">
                <input type="text" nc-notnul="Tên Thể loại không được bỏ trống"
                    class="form-control @error('content') is-invalid @enderror mb-0" name="content" id="content"
                    aria-describedby="nameHelp" value="{{$mess->content}}">
                <label class="form-label" for="form1">Lời nhắn</label>
                <div class="form-helper text-danger"><small id="nameHelp" class="form-text">
                        @error('content')
                        <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                        @enderror
                    </small></div>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" id="submit" class="btn btn-primary" name="submit"><i
                        class="fa fa-plus pe-1"></i>Để lại</button>
            </div>
        </div>

        @else
        <div class="row pb-3 ms-1">
            <div class="form-outline col-md-4">
                <input type="text" nc-notnul="Tên Thể loại không được bỏ trống"
                    class="form-control @error('content') is-invalid @enderror mb-0" name="content" id="content"
                    aria-describedby="nameHelp">
                <label class="form-label" for="form1">Lời nhắn</label>
                <div class="form-helper text-danger"><small id="nameHelp" class="form-text">
                        @error('content')
                        <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                        @enderror
                    </small></div>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" id="submit" class="btn btn-primary" name="submit"><i
                        class="fa fa-plus pe-1"></i>Để lại</button>
            </div>
        </div>
        @endif
    </div>
</form>
<div class="card-body container responsive ">


</div>
@endsection