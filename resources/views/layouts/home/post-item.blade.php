<div class="col-12 col-md-6 wow fadeInDown" data-wow-delay="0.4s">

    <div class="post-item pointer" link-to="">
        <div class="card post-detail">
            <div class=" card-header">
                <h4>{{$post->title}}</h4>
            </div>
            <?php
            use App\Models\Stfile;
             $idStfile = Stfile::find($post->idStfile);
                ?>
            <div class=" card-body">
                <a href="/storage/{{$idStfile->name}}">{{$idStfile->name}}</a>
                <div class="item-bg"></div>
                <a class="item-info @if($post->img_url == '/img/cover@1x.png') active @endif" href="">
                </a>
                <p>Yêu cầu: {{ $post->content }}
                <p>
                    <a href="/nopbai/{{$post->id}}"
                        class="btn btn-primary text-center align-content-center align-items-center">Nộp
                        bài</a>
            </div>
        </div>
    </div>
</div>