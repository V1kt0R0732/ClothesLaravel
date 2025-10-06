@extends('auth.cabinet')

@section('assets')
    @vite(['resources/css/client/cabinet_order.css', 'resources/js/client/cabinet_order.js'])
@endsection


@section('module')
    <!-- Мої замовлення -->
    <div class="card-body">
        <h5 class="mb-3">Мої замовлення</h5>

        <div class="list-group">

            <!-- Замовлення #1023 -->
            @foreach($orders as $order)
            <div class="list-group-item" data-bs-toggle="collapse" data-bs-target="#order-{{$order->order_id}}" aria-expanded="false">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>Замовлення #{{$order->order_id}}</strong><br>
                        <small class="text-muted">{{$order->created_at}}</small>
                    </div>
                    <span class="badge bg-{{$order->css_class}}">{{$order->status_text}}</span>
                </div>

                <!-- Деталі -->
                <div class="collapse order-details mt-2" id="order-{{$order->order_id}}">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            @foreach($order->clothes as $cloth)
                                <div class="d-flex justify-content-between">
                                    <img src="{{Storage::url($cloth->photo_name)}}" width="70px" alt="Фото Товару" class="img-fluid">
                                    <span>{{$cloth->cloth_name}}</span>
                                    <span>{{$cloth->quantity}} × {{$cloth->price}} грн</span>
                                </div>
                            @endforeach
                        </li>
                    </ul>
                    <div class="text-end fw-bold mt-2">Разом: {{$order->total_price}} грн</div>
                </div>
            </div>

            @endforeach



        </div>
    </div>


@endsection
