@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title">Daftar Produk</h1>

        <!-- Fetching product and stock data directly in the view -->
        @php
            // Retrieve products with their relations (category, supplier, warehouse, and stock)
            $products = \App\Models\Product::with('category', 'supplier', 'warehouse', 'stock')->get();
        @endphp

        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kode Produk</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Harga Pembelian</th>
                        <th>Harga Jual</th>
                        <th>Jumlah Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($product->purchase_price, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($product->sale_price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock->quantity ?? '0' }}</td>
                            <td>
                                <!-- Button to generate PDF for this product -->
                                <a href="{{ route('generate.product.and.stock.pdf', ['productId' => $product->id, 'stockType' => 'in']) }}"
                                    class="btn btn-primary btn-sm">Export PDF Stok Masuk</a>
                                <a href="{{ route('generate.product.and.stock.pdf', ['productId' => $product->id, 'stockType' => 'out']) }}"
                                    class="btn btn-secondary btn-sm">Export PDF Stok Keluar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .custom-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-in-out;
        }

        .custom-table th,
        .custom-table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-primary,
        .btn-secondary {
            padding: 8px 12px;
            background: #3498db;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-secondary {
            background: #95a5a6;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background: #2980b9;
            transform: scale(1.05);
        }

        .btn-sm {
            font-size: 0.875rem;
        }
    </style>
@endsection