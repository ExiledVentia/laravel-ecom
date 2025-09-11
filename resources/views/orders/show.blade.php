{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.master')

@section('content')
    <h1>Detail Order #{{ $order->id }}</h1>

    <p>Terima kasih atas pesanan Anda.</p>

    <div class="card">
        <div class="card-header">
            Status Pesanan: <strong>{{ strtoupper($order->status) }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            <p>Status pembayaran akan diperbarui secara otomatis. Anda akan melihat status 'PAID' di sini setelah pembayaran berhasil diverifikasi.</p>

            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->product->name }} ({{ $item->quantity }}x)</li>
                @endforeach
            </ul>
        </div>
    </div>

    <br>
    <a href="{{ route('products.index') }}">← Kembali Belanja</a>
@endsection