<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stfile;
use App\Models\Posts;
use App\Models\Files;
use App\Models\Challenge;

use Auth;
use Validator;
use DB;
use Storage;
use File;
use Carbon\Carbon;

class NopbaiController extends Controller
{
    public function index($id)
    {
        $posts = Posts::find($id);
        return view('layouts.home.nopbai.index', ['posts' => $posts]);
    }
    public function post(Request $request, $id)
    {
        $stFile=0;
        $url='';
        //Kiểm tra file
        if($request->hasFile('stFile')) {
            $filerade = $request->file('stFile');
            $fileradeData = File::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $fileradeExt = $filerade->getClientOriginalExtension();
            $filePath = $filerade->getRealPath();
            $fileSize = $filerade->getSize();
            $fileMime = $filerade->getMimeType();
            $url = Storage::put('public/upload/fileradepost/'.$fileradeName.Carbon::now().'.'.$fileradeExt, $fileradeData);
            $image = Stfile::create([
                'idUser' => Auth::id(),
                'name'  => 'upload/fileradepost/'.$fileradeName.Carbon::now().'.'.$fileradeExt,
                'description' => $fileSize,
                'type'  =>  'fileradepost',
                'options'   =>  '',
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
            ]);
            $stFile = $image->id;
        }
        $fileDatabase =   Files::create([
            'idPost' => $id,
            'idUser' => Auth::id(),
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'idStfile' => $stFile
        ]);
        $status = 'success';
        $message = '<h3>Thành công!</h3><p class="mb-0">Tài liệu <strong>'.'</strong> đã được tải lên!</p>';
        $thongbao = (json_encode(['status' => $status, 'message' => $message, 'title' => $request->title, 'url' => $url]));
        return redirect('/')->with('thongbao', $thongbao);
    }
    public function ans($id){
        $chall = Challenge::find($id);
        return view('layouts.home.trabai.index', ['chall' => $chall]);
    }
    public function postans(Request $request, $id){
        $chall = Challenge::find($id);
        if($chall->dapan == $request->dapan){
 
            $thongbao = (json_encode(['status' => 'success', 'message' => "Bạn trả lời đúng<br/><b>Nội dung file:</b>".$chall->noidungfile, 'title' => "Bạn trả lời đúng"]));
            return redirect('/')->with('thongbao', $thongbao);
        }
        $thongbao = (json_encode(['status' => 'danger', 'message' => "Bạn trả lời sai", 'title' => "Bạn trả lời sai"]));
        return redirect('/')->with('thongbao', $thongbao);;
    }
}
