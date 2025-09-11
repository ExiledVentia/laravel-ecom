@extends('layouts.master')

@section('content')
    <h1>Detail Produk</h1>
    <img src="{{ $product->image }}" alt="{{ $product->name }}" width="400">
    <p><strong>Nama:</strong> {{ $product->name }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p><strong>Stok:</strong> {{ $product->stock }}</p>

    <br>
    <a href="{{ route('products.index') }}">← Kembali ke daftar produk</a>

    <hr>

    @auth
        <h3>Checkout Produk Ini</h3>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <label for="quantity">Jumlah:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>

            <br><br>
            <button type="submit">Beli Sekarang</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Login dulu</a> untuk membeli produk ini.</p>
    @endauth
@endsection
