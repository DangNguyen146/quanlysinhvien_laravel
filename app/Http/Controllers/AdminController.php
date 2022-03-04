<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserUpdateRequest;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Auth;

use Illuminate\Support\Facades\Hash;
use DB;

class AdminController extends Controller
{
    public function home(){
        return view('admin.index');
    }
    public function index(){
        $listUser = User::all();
        return view('admin.user.index', compact('listUser'));
    }
    public function create(){
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }
    public function store(Request $request){
        // dd($request);
        try {
            DB::beginTransaction();
            $userCreat =User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'phone'=>$request->phone,
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
            ]);
            if($request->roles)
                $userCreat->assignRole($request->roles);
            DB::commit();
            return redirect()->route('ql_users.index');
        } catch (\Exception $exception) {
            DB::rollback();
            \Log::error('Error:' . $exception->getMessage() . $exception->getLine());
        }
    }

    public function edit($id){
        $roles = Role::all();
        $user=User::findOrFail($id);
        return view('admin.user.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id){
        $user =User::where('id', $id)->first();//user
        $roles = $request->roles;
        $submiter = Auth::user(); //Người submit

        if($request->change_info)
        {
            if($request->username != $user->username) {
                $user->update(['username'=>$request->username]);
            }
            if($request->name != $user->name) {
                $user->update(['name'=>$request->name]);
            }
            if($request->email != $user->email) {
                $user->update(['email'=>$request->email]);
            }
            $user->introduce = $request->introduce;
            $user->save();

            $thongbao = json_encode(['status'=>'success', 'message' => '<b>Đã thay đổi thông tin user!</b>']);
            return back()->with('thongbao', $thongbao);
        }
        elseif($request->change_role) {
            foreach($roles as $role){
                $user->removeRole($role);
            }
            $user->assignRole($request->roles);
            $thongbao = json_encode(['status'=>'success', 'message' => '<b>Đã thay đổi quyền!</b>']);
            return back()->with('thongbao', $thongbao);
        }
        elseif ($request->change_super_role) {
            if ($submiter->hasRole('teacher')) {
                foreach($roles as $role){
                    $user->removeRole($role);
                }
                $user->assignRole($request->roles);
            }
            $thongbao = json_encode(['status'=>'success', 'message' => '<b>Đã thay đổi quyền!</b>']);
            return back()->with('thongbao', $thongbao);
        }
        $thongbao = json_encode(['status'=>'danger', 'message' => '<b>Bạn không đủ quyền thực hiện hành động này!</b>']);
        return back()->with('thongbao', $thongbao);
    }
     public function delete($id){
        try {
            DB::beginTransaction();
            //delete
            $user=User::find($id);
            $user->delete($id);
            //delete user of role_user table
            $user->roles()->detach();       //xóa bản ghi thích hợp

            DB::commit();
            return response()->json([
                'code'=>200,
                'message'=>'success'
            ],200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'code'=>500,
                'message'=>'fail'
            ],500);
        }
    }
    
}
