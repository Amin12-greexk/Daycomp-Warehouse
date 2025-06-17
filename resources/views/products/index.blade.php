@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title"><i class="icon-box me-2"></i>Products</h1>
        <a href="{{ route('products.create') }}" class="btn-add-product">+ Add Product</a>

        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Date Added</th>
                        <th>Supplier</th> <!-- New column for Supplier -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="Product Image" class="product-image"
                                        style="max-width: 200px;">
                                @else
                                    <span class="no-image">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->category_name ?? 'No Category' }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->date_in ? date('Y-m-d', strtotime($product->date_in)) : 'N/A' }}</td>
                            <td>{{ $product->supplier->name ?? 'No Supplier' }}</td> <!-- Display supplier name -->
                            <td>
                                <a href="{{ route('products.qrcode', $product->id) }}" class="btn-action qr-btn">QR</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-action edit-btn">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            background: #f9f9f9;
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-in-out;
        }

        .btn-add-product {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #e74c3c);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-add-product:hover {
            background: linear-gradient(135deg, #e74c3c, #007bff);
            transform: scale(1.05);
        }

        .custom-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-in-out;
        }

        .custom-table th,
        .custom-table td {
            text-align: center;
            vertical-align: middle;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.1);
        }

        .no-image {
            color: #aaa;
            font-style: italic;
        }

        .btn-action {
            padding: 3px 10px;
            margin: 2px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            transition: transform 0.2s ease-in-out;
        }

        .qr-btn {
            background: #007bff;
        }

        .edit-btn {
            background: #f39c12;
        }

        .delete-btn {
            background: #e74c3c;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection