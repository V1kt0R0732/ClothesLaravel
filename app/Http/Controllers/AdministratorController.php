<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrator;
use App\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class AdministratorController extends Controller
{

    public function index(){
        return view('admin.user.index');
    }
    public function list(){
        $users = Administrator::join('permissions','permissions.permission_id','=','administrators.permission_id')->select('administrators.*','permissions.name as permission_name')->orderBy('permission_name','asc')->get();
        $permissions = Permission::all();

        return view('admin.user.list', compact('users','permissions'));
    }

    public function showRegistrationForm(){
        return view('admin.user.register');
    }
    public function register(Request $request){


        if ($request->input('password') != $request->input('password_confirmation')) {
            return redirect()->route('admin.registerForm')->with('error', 'Невірний пароль');
        }

        $user = new Administrator();

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
            $user = Administrator::where('email', $request->input('email'))->first();

            if (Hash::check($request->input('password'), $user->password)) {

                $perm = Permission::join('administrators','permissions.permission_id','=','administrators.permission_id')->where('administrators.email', $user->email)->select('permissions.name')->first();

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

        $user = Administrator::where('email', Session('user.email'))->first();

        if (Hash::check($request->input('old_password'), $user->password)) {
            $message = [];

//            Зміна E-mail
            $emailCheck = Administrator::where('email', $request->input('email'))->first();
            if(isset($emailCheck) && !empty($emailCheck)){
                $user->email = $request->input('email');
                session(['user.email' => $user->email]);
                $message[] = 'Емайл успішно змінено';
            }
            else{
                $message[] = 'Емейл не змінено. Така адресса вже використовується';
            }

//              Зміна Аватару
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');

                $user->avatar = $avatar->store('avatars', 'public');
                session(['user.avatar' => $user->avatar]);

                $user->update();

            }

//            Зміна ім'я
            $user->name = $request->input('name');
            session(['user.name', $user->name]);
            $message[] = "Ім'я успішно змінене";

//            Зміна пароля
            if(!empty($request->input('new_password')) && $request->input('new_password') == $request->input('confirm_password')){
                $user->password = Hash::make($request->input('new_password'));
                $message[] = 'Пароль успішно змінено';
            }

            $user->update();

            $message = implode(' | ',$message);


            return redirect()->route('admin.index')->with('success', $message);
        }

        return redirect()->route('admin.index')->with('error','Неправильно введений пароль');

    }


    public function delete($id){


        return redirect()->route('admin.list')->with('error','Видалення користувачів заборонено');

    }

    public function changeId(Request $request){

        $user = Administrator::where('id', $request->input('id'))->first();
        $user->permission_id = $request->input('perm');
        $user->update();

        return redirect()->route('admin.list')->with('success','Роль успішно змінена');
    }


    public function logout(){

        Session::forget('user');

        return redirect()->route('admin.loginForm');

    }


}
