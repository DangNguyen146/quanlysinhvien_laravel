<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stfile;
use App\Models\Challenge;

use Auth;
use Validator;
use DB;
use Storage;
use File;

class ChallengeController extends Controller
{
    public function index(){
        $challenges = DB::table('challenges')->orderBy('updated_at', 'desc')->get();
        return view('admin.challenges.index', compact('challenges'));
    }
    public function create(){
        return view('admin.challenges.add');
    }
    public function store(Request $request){
        // Upload file
        $stFile = 0;
        $dapan = '';
        $noidungfile='';
        if($request->hasFile('stFile')) {
            $filerade = $request->file('stFile');
            $noidungfile = File::get($filerade);
            $fileradeData = File::get($filerade->getRealPath());
            $fileradeName = $filerade->getClientOriginalName();
            $dapan = substr($fileradeName, 0, -4);
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
        $chall =  Challenge::create([
            'idStfile' => $stFile,
            'dapan' => $dapan,
            'title' => $request->title,
            'content' => isset($request->content) ? $request->content : '',
            'noidungfile' => $noidungfile,
            'status' => isset($request->status) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ]);
        $thongbao = json_encode([
                'url' => '/quanly/thutach/',
                'title' => $request->title,
                'status'=>'success',
                'message' => '<h3>Thành công!</h3><p class="mb-0">Bài viết <strong>'.$request->title.'</strong> đã được tạo!</p>',
        ]);
        return redirect('/quanly/thuthach/')->with('thongbao', $thongbao);
    }

    public function edit($id)
    {
        $chall = Challenge::find($id);
        if(!$chall) return redirect('/quanly/thuthach');

        $idStfile=Stfile::find($chall->idStfile);
        
        return view('admin.challenges.edit', ['chall' => $chall, 'idStfile' =>$idStfile]);
    }
}
