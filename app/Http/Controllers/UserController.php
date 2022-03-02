<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Storage;
use File;
use DB;

use Auth;

class UserController extends Controller
{
    public function index($username){
        $user = User::where('username', $username)->first();
        $mess = Message::where('idUserS', Auth::id())->first();
        // dd($mess);
        return view('user.index', ['user'=>$user, 'mess'=>$mess]);
        
    }
    public function info(Request $request, $username) {
    	$user = User::where('username', $username)->first();
    	if(Auth::user() != $user) {
    		return redirect('/u/'.$username);
    	}
        if($user) {
            return view('user.info', ['user'=>$user, 'request'=>$request]);
        } else {
            return redirect('/');
        }
    }
   
    
    public function saveinfo(Request $request, $username) {
    	$user = User::where('username', $username)->first();
    	if(Auth::user() != $user) {
    		return redirect('/u/'.$username);
    	}
        if($user) {
        	$status = 'danger';
        	$errors = array();
        	$message = 'Không có thông tin nào thay đổi!';
            $changUname = false;
        	if($request->change_pass) {
        		$data = array(
        			'username'	=>	$username,
        			'password'	=>	$request->oldpass
        		);
        		if(Auth::attempt($data)) {
        			if($request->newpass === $request->confirm_newpass)
        			{
        				$user->password = bcrypt($request->newpass);
        				$user->save();
        				$status = 'success';
        				$message = 'Mật khẩu đã đổi thành công!';
        			} else {
        				$message = 'Mật khẩu mới và Phần xác nhận phải giống nhau!';
        				$errors = array('confirm' => 'confirm');
        			}
        		} else {
        			$message = 'Sai mật khẩu hiện tại!';
        			$errors = array('oldpass' => 'Sai mật khẩu hiện tại!');
        		}
        	} else if($request->change_email) {
        		$data = array(
        			'username'	=>	$username,
        			'password'	=>	$request->email_confirm_pass
        		);
        	} else if($request->change_info){
                $message = '';
                if($request->username != $user->username) {
                    $check = request()->validate([
                        'username' => ['required','string','max:20','min:3','unique:users',new Username()]
                    ]);
                    $old_username = $user->username;
                    $save = $user->changeUsername($request->username);
                    if($save) {
                        $message .= 'Đã đổi username thành <b>'.$request->username.'</b>. ';
                        $changUname = true;
                    }
                }
                if($request->name != $user->name) {
                    $old_name = $user->name;
                    $check = request()->validate([
                        'name' => ['required','string','max:255']
                    ]);
                    $save = $user->changeName($request->name);
                    if($save) {
                        $message .= 'Đã đổi tên hiển thị thành <b>'.$request->name.'</b>. ';
                    }
                }
                if($request->imgavatar != $user->avatar){
                    // dd($request->imgavatar);
                    if($request->hasFile('imgavatar')) {
                           // Xóa hình
                           $image = Images::find($user->avatar);
                           if($image) {
                            Storage::delete($image->name);
                            $image->forceDelete();
                        }
                        $img = $request->file('imgavatar');
                        $imgData = File::get($img->getRealPath());
                        $imgExt = $img->getClientOriginalExtension();   //Lấy Đuôi File
                        $filePath = $img->getRealPath();    //Lấy đường dẫn tạm thời của file
                        $fileSize = $img->getSize();    //Lấy kích cỡ của file đơn vị tính theo bytes
                        $fileMime = $img->getMimeType();    //Lấy kiểu file
                        // dd($fileMime);
                        $url = Storage::put('public/upload/avatar/'.$username.'.'.$imgExt, $imgData);
                        try {
                            DB::beginTransaction();
                            $image = Images::create([
                                'idUser' => Auth::id(),
                                'name'  => 'upload/avatar/'.$username.'.'.$imgExt,
                                'description' => $fileSize,
                                'type'  =>  'avatar',
                                'options'   =>  '',
                            ]);
                            DB::commit();
                            $user->avatar = $image->name;
                            $user->save();
                            $status = 'success';
        			$message = 'Anh đại diện đã thay đổi thành công!';
                        } catch (\Exception $exception) {
                            DB::rollback();
                            \Log::error('Error:' . $exception->getMessage() . $exception->getLine());
                        }

                    }
                }

                if($request->introduce != $user->introduce) {
                    $check = request()->validate([
                        'introduce' => ['max:500']
                    ]);
                    $user->introduce = $request->introduce;
                    $user->save();
                    $message .= 'Đã cập nhật thông tin giới thiệu.';
                }
                $status = 'success';
                if($message == '')
                {
                    $status = 'warning';
                    $message = 'Không có thông tin nào được thay đổi! ';
                }
        	}

            $thongbao = (json_encode(['status' => $status, 'message' => $message]));
            if($status == 'success') { $user->updated_at = date('Y-m-d H:i:s',time()); $user->save(); }
            if($changUname) {
                $return = redirect(route('thongtin_user', $user->username));
            } else $return = back();
            return $return->withErrors($errors)->with('thongbao', $thongbao);
        } else {
            return redirect('/');
        }
    }
    public function sendmess(Request $request, $user)
    {
        try {
            DB::beginTransaction();
            //update bảng role_table
            $mess = Message::where('idUserS', Auth::id())->first();
            if($mess){
                $mess->update([
                    'idUserS' => Auth::id(),
                    'idUserR' => $user,
                    'content' => $request->content,
                    'updated_at' => date('Y-m-d H:i:s',time()),
                ]);
            }
            else{
                Message::create([
                    'idUserS' => Auth::id(),
                    'idUserR' => $user,
                    'content' => $request->content,
                    'created_at' => date('Y-m-d H:i:s',time()),
                    'updated_at' => date('Y-m-d H:i:s',time()),
                ]);
            }
           
            DB::commit();
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error('Error:' . $exception->getMessage() . $exception->getLine());
        }
    }

}
