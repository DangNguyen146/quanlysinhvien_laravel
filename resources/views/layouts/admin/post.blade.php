<div class="col-md-2 rounded">
    <div class="post-item border-primary br-3" nc-class-hover="bg-primary">
        <a href="{{route('ql_baiviet.show', $post->id)}}" nc-class-hover="text-white">
            <div class="post-item-left" style="background-image: url({{$post->img_url}});">
            </div>
            <div class="post-item-right">
                <h6 style="font-size: 15px; text-align: center;" class="m-auto">{{$post->title}}</h6>
            </div>
        </a>
    </div>
</div>
