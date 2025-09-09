
@extends('layouts.app')

@section('content')
    <h1>Detail Order #{{ $order->id }}</h1>

    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    <p><strong>Invoice ID:</strong> {{ $order->xendit_invoice_id }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>

    <h3>Item dalam order:</h3>
    @if($order->items->isEmpty())
        <p>Tidak ada item.</p>
    @else
        <ul>
            @foreach($order->items as $item)
                <li>
                    {{ $item->product->name }} 
                    ({{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }})
                </li>
            @endforeach
        </ul>
    @endif

    <br>
    <a href="{{ route('orders.index') }}">Kembali ke daftar order</a>
@endsection
