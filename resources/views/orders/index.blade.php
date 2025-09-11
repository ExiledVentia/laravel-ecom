
@extends('layouts.master')

@section('content')
    <h1>Daftar Order</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($orders->isEmpty())
        <p>Belum ada order.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Invoice ID</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->xendit_invoice_id }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
