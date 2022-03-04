<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\RoleAddRequest;
use DB;

class RoleController extends Controller
{
    //list all role
    public function index(){
        $listRole =  DB::table('roles')->get();
        return view('admin.role.index', compact('listRole'));
    }

    public function show(){
        $listRole = Role::all();
        return view('admin.role.index', compact('listRole'));
    }

    //show form create
    public function create(){
        
        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions'));
    }
    public function store(Request $request){
        try {
            DB::beginTransaction();
            // Insert data to role table
            $roleCreate = Role::create([ 
                'name' => $request->name,
                'description' => isset($request->description) ? $request->description : '',
                'status' => isset($request->status) ? 1 : 0,
            ]);
            // thêm permission vào role
            if($request->permissions)
                foreach($request->permissions as $permission){
                    $roleCreate->givePermissionTo($permission);
                }

            DB::commit();
            return redirect()->route('ql_roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error('Error:' . $exception->getMessage() . $exception->getLine());
        }
    }
    public function edit($id){
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $getPermission = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id');
        return view('admin.role.edit', compact('permissions', 'role', 'getPermission'));
    }
    public function update(Request $request, $id){
        try {
            DB::beginTransaction();
            //update bảng role_table
            Role::where('id', $id)->update([
                'name' => $request->name,
                'description' => isset($request->description) ? $request->description : '',
                'status' => isset($request->status) ? 1 : 0,
            ]);
            //update bảng trung gian
            DB::table('role_has_permissions')->where('role_id', $id)->delete();
            $roleCreate = Role::find($id);
            if($request->permissions)
                foreach($request->permissions as $permission){
                    $roleCreate->givePermissionTo($permission);
                }

            DB::commit();
            return redirect()->route('ql_roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error('Error:' . $exception->getMessage() . $exception->getLine());
        }
    }
    public function delete($id){
        try{
            $role= Role::find($id);
            $role->delete($id);

            $role->permissions()->detach();       //xóa bản ghi thích hợp
            $thongbao = json_encode([
                'url' => '/quanly/roles/',
                'title' => "Xóa thành công",
                'status'=>'success',
                'message' => '<h3>Thành công!</h3><p class="mb-0">Role đã được xóa!</p>',
        ]);
            return redirect('/quanly/roles/')->with('thongbao', $thongbao);

        }catch(\Exception $exception){
            Log::error("Message: " . $exception->getMessage() . "Line: ". $exception->getLine());
            return response()->json([
                'code'=>500,
                'message'=>'fail'
            ],500);
        }
    }

}
