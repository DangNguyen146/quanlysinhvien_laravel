<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //   create acc
         $userTeacher= User::create(['name' => 'teacher', 'username'=> 'teacher', 'email' => 'teacher@gmail.com', 'password' => bcrypt('teacher'), 'created_at' => NOW()]);
         $userStudent= User::create(['name' => 'student', 'username'=> 'student', 'email' => 'student@gmail.com', 'password' => bcrypt('student'), 'created_at' => NOW()]);

         //create permissions
        $permissions =['user-list', 'user-add', 'user-edit', 'user-delete', 'role-list', 'role-add', 'role-edit', 'role-delete','baiviet-list', 'baiviet-add',  'baiviet-edit', 'baiviet-delete',  'tailieu-list', 'tailieu-add', 'tailieu-edit', 'tailieu-delete'];
        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        //create role
        $teacher = Role::create([ 'name' => 'teacher', 'created_at' => NOW()]);
        $student = Role::create([ 'name' => 'student', 'created_at' => NOW()]);

        //crete role_has_permission
        $teacherPermissions=['user-list', 'user-add', 'user-edit', 'user-delete', 'role-list', 'role-add', 'role-edit', 'role-delete','baiviet-list', 'baiviet-add',  'baiviet-edit', 'baiviet-delete',  'tailieu-list', 'tailieu-add', 'tailieu-edit', 'tailieu-delete'];
        foreach ($teacherPermissions as $permission)   {
            $teacher->givePermissionTo($permission);
        }

        //trao role cho user
        $userTeacher->assignRole($teacher);
    }
}
