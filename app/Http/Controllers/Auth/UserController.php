<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public $url;

    public function __construct(){
        $this->url = explode('/', parse_url(url()->current())['path'])[2];
    }

    public function index(){

        return view('auth.profile.main', ['url'=>$this->url]);

    }

    public function orders(){

        $orders = OrderController::getOrders();


        return view('auth.profile.orders', ['url'=>$this->url, 'orders'=>$orders]);
    }

    public function settings(){

        return view('auth.profile.settings', ['url'=>$this->url]);

    }

    public function edit(Request $request){

        $checkEmail = User::where('email', $request->email)->first();

        $session = 'success';
        $message = 'Успішно змінено дані';

        if(isset($checkEmail) && !empty($checkEmail)){
            if($checkEmail->id != auth()->user()->id){
                return redirect()->route('cabinet.main')->with('warning', 'Дана електронна пошта вже використовується іншим користувачем');
            }
            $message = 'Змінено Ім\'я користувача';
            $session = 'warning';
        }


        $user = User::find(auth()->user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();



        return redirect()->route('cabinet.main')->with($session, $message);
    }

    public function settingsUpdate(Request $request){

        $user = User::find(auth()->user()->id);

        if(Hash::make($request->pass) != $user->password){
            return redirect()->route('cabinet.settings')->with('error', 'Старий пароль введено не вірно');
        }


        redirect()->route('cabinet.settings')->with('success', 'Успішно змінено дані');

    }


}
