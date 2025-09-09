
@extends('layouts.app')

@section('content')
    <h1>Checkout</h1>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <label for="product_id">Produk:</label>
        <select name="product_id" id="product_id" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label for="quantity">Jumlah:</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1" required>
        <br><br>

        <button type="submit">Buat Order</button>
    </form>
@endsection
