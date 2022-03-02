<div class="col-12 col-md-3 card">
    {{-- <a href="" nc-class-hover="text-white">
        <div class="file-item br-3" nc-class-hover="bg-primary" nc-class-hover="text-white">
            <div class="file-item-top bg-white" style="background-image: url({{$file->img_url}});">
                <div class="sticky-top-right">
                    <div class="relative">
                        <button class="btn btn-primary rounded-circle px-3 py-2">
                            <i class="fas fa-file-powerpoint"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="file-item-bottom">
                <h6 style="font-size: 15px; text-align: center;" class="m-auto"> {{$file->title}}</h6>
            </div>
        </div>
    </a> --}}
    <div class=" card-header">
        <h4>Tiêu đề: {{$file->title}}</h4>
    </div>
    <div class="card-body">
        <?php
            use App\Models\User;
            $user = User::where('id', $file->idUser)->first();
                ?>
        <p>Tên sinh viên: {{$user->name}}</p>
        <?php
            use App\Models\Stfile;
             $idStfile = Stfile::find($file->idStfile);
                ?>
        Link đính kèm: <a href="/storage/{{$idStfile->name}}">{{$idStfile->name}}</a>
        <div class="item-bg"></div>
        </a>
        <p>Bài làm: {{ $file->content }}
        <p>

    </div>
</div>