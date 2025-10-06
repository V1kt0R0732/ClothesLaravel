@extends('admin.layouts.layout', ['title' => 'Перегляд замовлень'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Список замовлень</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ім'я</th>
                                    <th>Телефон</th>
                                    <th>Статус</th>
                                    <th>Дата створення</th>
                                    <th>Дата оновлення</th>
                                    <th>Дія</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>
                                            @if ($order->status)
                                                <span class="badge bg-success">Завершено</span>
                                            @else
                                                <span class="badge bg-warning">В обробці</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', ['id'=>$order->order_id]) }}" class="btn btn-info btn-sm" title="Переглянути">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.orders.archive', $order->order_id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Видалити" onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
