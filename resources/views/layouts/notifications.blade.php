<div id="thong-bao">
    {!! Helpers::showThongBaoCookie() !!}
    @if(isset($thongbao))
    {!! Helpers::showThongBao($thongbao)!!}
    @endif
    @if(session('thongbao'))
    <?php $thongbao = json_decode(session('thongbao')); ?>
    <div class="toast alert alert-{{$thongbao->status}} alert-dismissible shadow toast-fixed fade show"
        id="placement-toast" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false"
        data-mdb-position="top-right" data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px"
        data-mdb-color="info">
        <div class="toast-header">
            <strong class="me-auto">Thông báo</strong>
            <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body py-2">{!! $thongbao->message !!}</div>
    </div>
    @endif
</div>