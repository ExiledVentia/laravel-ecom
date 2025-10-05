@extends('layouts.master')

@section('content')
    <h1>Daftar Produk</h1>

    <div>
        <form action="{{ route('products.index') }}" method="GET">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
            @if(request('search'))
                <a href="{{ route('products.index') }}">Reset</a>
            @endif
        </form>
    </div>

    @if (session('success'))
            {{ session('success') }}
    @endif

    @if ($products->isEmpty())
        <p>Belum ada produk.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}">Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>
        {{ $products->links() }}
    @endif

    <br>
    <a href="{{ route('products.create') }}">+ Tambah Produk</a>
@endsection