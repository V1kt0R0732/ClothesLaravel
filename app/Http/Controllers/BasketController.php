<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorageClothes;
use App\Models\Clothes;

class BasketController extends Controller
{

    public function index(Request $request)
    {


        $basket = $request->session()->get('basket', []);
        $clothes = Clothes::join('storage_clothes','clothes.cloth_id','=','storage_clothes.cloth_id')
            ->join('photos','storage_clothes.storage_cloth_id','=','photos.storage_cloth_id')
            ->join('sizes', 'storage_clothes.size_id', '=', 'sizes.size_id')
            ->join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
            ->join('body_shapes', 'storage_clothes.body_shape_id', '=', 'body_shapes.body_shape_id')
            ->whereIn('storage_clothes.storage_cloth_id', array_keys($basket))
            ->where('photos.status', 1)
            ->get();

        $totalPrice = 0;
        foreach ($clothes as $cloth) {
            $totalPrice += $cloth->price * $basket[$cloth->storage_cloth_id]['quantity'];
        }



        return view('client.basket', compact('clothes', 'basket', 'totalPrice'));
    }

    public function add(Request $request){

        //session()->flush();

        $clothes = StorageClothes::find($request->id);
        if (!$clothes) {
            return redirect()->back()->with('error', 'Річ не знайдена');
        }

        $basket = session()->get('basket', []);
        $basket_count = session()->get('basket_count', 0);
        if (isset($basket[$clothes->storage_cloth_id])) {
            $basket[$clothes->storage_cloth_id]['quantity'] += 1;
        } else {
            $basket[$clothes->storage_cloth_id] = [
                'id' => $clothes->storage_cloth_id,
                'quantity' => 1,
            ];
        }
        if(isset($basket_count) && !empty($basket_count)){
            $basket_count += 1;
        } else {
            $basket_count = 1;
        }

        session()->put('basket', $basket);
        session()->put('basket_count', $basket_count);
        return redirect()->back()->with('success', 'Успішно додано до кошика');

    }

    public function remove($id){
        $clothes = StorageClothes::find($id);
        if (!$clothes) {
            return redirect()->back()->with('error', 'Річ не знайдено');
        }

        $basket = session()->get('basket', []);
        $basket_count = session()->get('basket_count');

        if (isset($basket[$clothes->storage_cloth_id])) {
            $basket_count -= $basket[$clothes->storage_cloth_id]['quantity'];
            unset($basket[$clothes->storage_cloth_id]);
            session()->put('basket', $basket);
            session()->put('basket_count', $basket_count);
            return redirect()->back()->with('success', 'Предмет видалено з кошика');
        } else {
            return redirect()->back()->with('error', 'Предмету немає в кошику');
        }
    }

    public function clear(Request $request){
        $request->session()->forget('basket');
        $request->session()->forget('basket_count');
        return redirect()->back()->with('success', 'Кошик очищено');
    }

    public function recalc(Request $request){

        $basket = session()->get('basket', []);
        $basket_count = session()->get('basket_count');


        foreach ($basket as $key => $array) {
            $max_quantity = StorageClothes::find($key)->count;
            if($request->input('count_'.$key) > $max_quantity){
                return redirect()->back()->with('error', 'Максимальна кількість для товару id '.$key.' становить '.$max_quantity);
            }
            $basket[$key]['quantity'] = $request->input('count_'.$key);
            $basket_count += $basket[$key]['quantity'] - $array['quantity'];
        }

        session()->put('basket', $basket);
        session()->put('basket_count', $basket_count);

        return redirect()->back()->with('success', 'Корзина оновлена');

    }

}
