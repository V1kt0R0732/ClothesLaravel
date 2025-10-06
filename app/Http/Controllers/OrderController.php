<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use App\Models\StorageClothes;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index() {

        $basket = session()->get('basket', []);

        if(empty($basket)) {
            return redirect()->route('home')->with('error', 'Ваш кошик порожній');
        }

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

        $user = auth()->user();

        return view('client.order', compact('basket', 'clothes','totalPrice','user'));

    }

    public function makeOrder(Request $request) {

        $basket = session()->get('basket', []);

        $clothes = StorageClothes::whereIn('storage_cloth_id', array_keys($basket))->get();

        foreach ($clothes as $cloth) {
            $cloth->count -= $basket[$cloth->storage_cloth_id]['quantity'];
            $cloth->save();
        }

        $order = new Order();
        $order->user_id = auth()->id();
        $order->phone = $request->phone;
        $order->shipping_address = $request->adress;
        $order->products = json_encode($basket);

        $order->save();

        session()->forget('basket');
        session()->forget('basket_count');


        // Clear the basket after order is made
        $request->session()->forget('basket');
        $request->session()->forget('basket_count');

        return view('client.order_success');
    }

    public static function getOrders() {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        foreach ($orders as $order) {
            $order->products = json_decode($order->products, true);
            $storageClothIds = array_keys($order->products);
            $clothes = Clothes::join('storage_clothes','clothes.cloth_id','=','storage_clothes.cloth_id')
                ->join('photos','storage_clothes.storage_cloth_id','=','photos.storage_cloth_id')
                ->whereIn('storage_clothes.storage_cloth_id', $storageClothIds)
                ->where('photos.status', 1)
                ->get();
            $order->clothes = $clothes;
            switch ($order->status) {
                case 0:
                    $order->status_text = 'Новий';
                    $order->css_class = 'success';
                    break;
                case 1:
                    $order->status_text = 'В обробці';
                    $order->css_class = 'warning';
                    break;
                case 2:
                    $order->status_text = 'Відправлено';
                    $order->css_class = 'info';
                    break;
                case 3:
                    $order->status_text = 'Скасовано';
                    $order->css_class = 'danger';
                    break;
            }
            $order->total_price = 0;
            foreach($order->clothes as $cloth) {
                $cloth->quantity = $order->products[$cloth->storage_cloth_id]['quantity'];
                $order->total_price += $cloth->price * $cloth->quantity;
            }

        }
        return $orders;
    }

    public static function admin_show_orders_list(){

//        TODO: Доробити вивід замовлень та їх деталізацію

        $orders = Order::orderBy('status','desc')->get();

        return view('admin.orders.list', compact('orders'));
    }


}
