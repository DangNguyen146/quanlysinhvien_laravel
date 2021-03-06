<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helpers;
use App\Models\Stfile;
use App\Models\Posts;
use App\Models\Files;

use Auth;
use Validator;
use DB;
use Storage;
use File;

use App\Http\Requests\PostPostRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    public function index(){
        $posts = DB::table('posts')->orderBy('updated_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }
    public function create(){
        return view('admin.posts.add');
    }
    public function store(PostPostRequest $request){
        // Upload file
        $stFile = 0;
        if($request->hasFile('stFile')) {
                $filerade = $request->file('stFile');
                $fileradeData = File::get($filerade->getRealPath());
                $fileradeName = $filerade->getClientOriginalName();
                $fileradeExt = $filerade->getClientOriginalExtension();
                $filePath = $filerade->getRealPath();
                $fileSize = $filerade->getSize();
                $fileMime = $filerade->getMimeType();
                $url = Storage::put('public/upload/fileradepost/'.$fileradeName.'.'.$fileradeExt, $fileradeData);
                $image = Stfile::create([
                    'idUser' => Auth::id(),
                    'name'  => 'upload/fileradepost/'.$fileradeName.'.'.$fileradeExt,
                    'description' => $fileSize,
                    'type'  =>  'fileradepost',
                    'options'   =>  '',
                    'created_at' => date('Y-m-d H:i:s',time()),
                    'updated_at' => date('Y-m-d H:i:s',time()),
                ]);
                $stFile = $image->id;

        }
        // INSERT
        $post =  Posts::create([
            'idStfile' => $stFile,
            'idUser' => Auth::id(),
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'status' => isset($request->status) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
        $thongbao = json_encode([
                'url' => '/quanly/baiviet/',
                'title' => $request->title,
                'status'=>'success',
                'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>'.$request->title.'</strong> ???? ???????c t???o!</p>',
        ]);
        return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
    }
    public function edit($id)
    {
        $post = Posts::find($id);
        if(!$post) return redirect('/quanly/baiviet');

        $idStfile=Stfile::find($post->idStfile);
        
        return view('admin.posts.edit', ['post' => $post, 'idStfile' =>$idStfile]);
    }
    public function show($id){
        $post = Posts::find($id);
        $files = Files::where('idPost', $id)->orderBy('id', 'desc')->get();
        if($post) {
            
            return view('admin.posts.show', ['post'=>$post, 'files' => $files]);
        } else {
            $thongbao = json_encode(['status'=>'danger', 'message' => 'B??i vi???t kh??ng t???n t???i!']);
            return redirect('/quanly/danhmuc/')->with('thongbao', $thongbao);
        }
    }
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Posts::find($id);
        $stFile = 0;
        if($request->hasFile('stFile')) {
                $filerade = $request->file('stFile');
                $fileradeData = File::get($filerade->getRealPath());
                $fileradeName = $filerade->getClientOriginalName();
                $fileradeExt = $filerade->getClientOriginalExtension();
                $filePath = $filerade->getRealPath();
                $fileSize = $filerade->getSize();
                $fileMime = $filerade->getMimeType();
                $url = Storage::put('public/upload/fileradepost/'.$fileradeName.'.'.$fileradeExt, $fileradeData);
                $image = Stfile::create([
                    'idUser' => Auth::id(),
                    'name'  => 'upload/fileradepost/'.$fileradeName.'.'.$fileradeExt,
                    'description' => $fileSize,
                    'type'  =>  'fileradepost',
                    'options'   =>  '',
                    'created_at' => date('Y-m-d H:i:s',time()),
                    'updated_at' => date('Y-m-d H:i:s',time()),
                ]);
                $stFile = $image->id;

                $post->idStfile = $stFile;
        }

        // UPDATE
        $post->title = $request->title;
        $post->content = isset($request->content) ? $request->content : '';
        $post->status = isset($request->status) ? 1 : 0;
        $post->updated_at = date('Y-m-d H:i:s',time());
        $post->save();
        $thongbao = json_encode([
            'url' => '/quanly/baiviet/',
            'title' => $request->title,
            'status'=>'success',
            'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>'.$request->title.'</strong> ???? ???????c C???p nh???t!</p>',
        ]);
        return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
    }
    public function delete($id)
    {
        $post = Posts::find($id);
        if(!$post) {
            return json_encode([
                        'url' => '/quanly/baiviet/',
                        'status'=> 'error',
                        'message' => '<h3>L???i!</h3><p class="mb-0">B??i vi???t n??y kh??ng t???n t???i!</p>',
                    ]);
        } else {
            try{
            // Ki???m tra v?? t???o Th??ng r??c
            $trashName = 'Th??ng R??c';
                // Ki???m tra xem ???? c?? th??ng r??c ch??a
                $contents = collect(Storage::cloud()->listContents('/', false));
                $trash = $contents->where('type', '=', 'dir')
                    ->where('filename', '=', $trashName)
                    ->first();
                if($trash == null) { // N???u ch??a th?? t???o Th??ng R??c
                    $status = Storage::cloud()->makeDirectory($trashName);
                    $contents = collect(Storage::cloud()->listContents('/', false));
                    $trash = $contents->where('type', '=', 'dir')
                        ->where('filename', '=', $trashName)
                        ->first();
                }
            // Chuy???n to??n b??? File v??? B??i vi???t 0
            $files = Files::where('idPost', $id)->get();
            if(count($files) > 0) {
                foreach ($files as $file) {
                    $f = Files::find($file->id);
                    $f->idPost = 0;
                    $f->save();
                }
            }
            // Di chuy???n Files trong Drive v??o Th??ng R??c
            $fileChilds = collect(Storage::cloud()->listContents($post->idDrive, false))->where('type', '=', 'file');
            if(count($fileChilds) > 0) {
                foreach ($fileChilds as $fileChild) {
                    Storage::cloud()->move($fileChild['path'], $trash['path'].'/'.$fileChild['filename'].'.'.$fileChild['extension']);
                }
            }
            // X??a h??nh minh h???a
            $image = Stfile::find($post->idfilerade);
            if($image) {
                Storage::delete($image->name);
                $image->forceDelete();
            }
            // X??a
            $directory = collect(Storage::cloud()->listContents('/', true))
            ->where('type', '=', 'dir')
            ->where('basename', '=', $post->idDrive)
            ->first();
            Storage::cloud()->deleteDirectory($directory['path']);
            $post->forceDelete();
            $thongbao = json_encode([
                        'url' => '/quanly/baiviet/',
                        'title' => 'Qu???n l?? B??i vi???t',
                        'status'=>'success',
                        'message' => '<h3>Th??nh c??ng!</h3><p class="mb-0">B??i vi???t <strong>'.$post->title.'</strong> ???? ???????c x??a th??nh c??ng!</p>',
                    ]);
            Helpers::setThongBaoCookie($thongbao);
            }catch(\Exception $exception){
                Log::error("Message: " . $exception->getMessage() . "Line: ". $exception->getLine());
                return response()->json([
                    'code'=>500,
                    'message'=>'fail'
                ],500);
            }
            return redirect('/quanly/baiviet/')->with('thongbao', $thongbao);
        }
    }
}
