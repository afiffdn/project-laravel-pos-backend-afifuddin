<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(Request $request){
        $users =\App\Models\User::latest()
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->paginate(10);
        return view('pages.users.index',[
            'users' => $users,
            'type_menu'=>'user'
        ]);
    }

    public function create(){
        return view('pages.users.create',[
    'type_menu'=>'']);
    }

    public function store(StoreUserRequest $request){

        // dd($request->all());  FUNGSI NYA BUAT DEBUGGING
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        \App\Models\User::create($data);
        return redirect()->route('user.index')->with('success', 'User successfully created');
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit',['type_menu'=>''], compact('user'));
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->validate($request,[
            'name'  =>'required',
            // 'email'  =>'required',
            'email' =>'required|email|unique:users,email,' . $user->id,
        ]);
        if($request->password==''){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'roles'=>$request->roles,
            ]);
        }else{
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'phone'=>$request->phone,
                'roles'=>$request->roles,
            ]);
        }
        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }
}
