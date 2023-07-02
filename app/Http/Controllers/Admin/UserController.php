<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    function index(){
        $users = User::all();
        return view('admin.user.index',compact('users'));

    }

    function edit($user_id){
        $user = User::find($user_id);
        return view('admin.user.edit',compact('user'));

    }

    function update(UserRequest $request,$user_id){



        $user = User::find($user_id);
        if ($user) {
            # code...
            $data = $request->validated(); //validated data has go into $data
            $user = User::find($user_id);
            $user-> name=$data['name'];
            $user-> email=$data['email'];
            $user->role_as =$request['role_as'];

            $user->update();
            return redirect('admin/user')->with('message','Updated succeccfully');
        }
        return redirect('admin/user')->with('message','Updated failed');

    }
}
