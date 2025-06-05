<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{

    public function index(){
        return view('admin.user.index');
    }
    public function list(){

        $users = User::join('permissions','permissions.permission_id','=','users.permission_id')->select('users.*','permissions.name as permission_name')->orderBy('permission_name','asc')->get();


        return view('admin.user.list', compact('users'));
    }

    public function showRegistrationForm(){
        return view('admin.user.register');
    }
    public function register(Request $request){


        if ($request->input('password') != $request->input('password_confirmation')) {
            return redirect()->route('admin.registerForm')->with('error', 'Невірний пароль');
        }

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
//        $user->password = sha1($request->input('password'));
        $user->password = Hash::make($request->input('password'));
        $user->permission_id = $request->input('role');

        $user->save();

        return redirect()->route('admin.registerForm')->with('success', 'Користувач успішно зареєстровано');


    }
    public function showLoginForm(){
        return view('admin.user.login');
    }

    public function login(Request $request){

        try {
            $user = User::where('email', $request->input('email'))->first();

            if (Hash::check($request->input('password'), $user->password)) {

                $perm = Permission::join('users','permissions.permission_id','=','users.permission_id')->where('users.email', $user->email)->select('permissions.name')->first();

                session(['user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email,'avatar' => $user->avatar,'permission' => $perm->name]]);

                return redirect()->route('admin.list')->with('success','Успішний вхід в систему');

            }
            else {
                return redirect()->route('admin.loginForm')->with('error', 'Пароль не вірний');
            }
        }
        catch (\Exception $exception){
            return redirect()->route('admin.loginForm')->with('error', 'Неправильно введені дані');
        }
    }


    public function edit(Request $request){

        dd($request);
    }


    public function logout(){

        Session::forget('user');

        return redirect()->route('admin.loginForm');

    }


}
