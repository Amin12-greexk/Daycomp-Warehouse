@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title text-center mb-4">Daftar Stok Produk</h1>
        <div class="text-center mb-4">
            <a href="{{ route('stocks.create') }}" class="btn btn-primary">+ Tambah Stok</a>


            <!-- Table for displaying stocks -->
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover custom-table">
                    <thead class="thead-dark">
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
                        @foreach ($stocks as $index => $stock)
                            <tr>

                                <td>{{ $index + 1 }}</td>
                                <td>{{ $stock->product->product_name ?? 'N/A' }}</td>
                                <td>{{ $stock->product->product_code ?? 'N/A' }}</td>
                                <td>{{ $stock->product->category->category_name ?? 'N/A' }}</td>
                                <td>{{ $stock->product->supplier->name ?? 'N/A' }}</td>
                                <td>Rp {{ number_format($stock->product->purchase_price, 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($stock->product->sale_price, 2, ',', '.') }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>
                                    <!-- Reduce Stock Form -->
                                    <form action="{{ route('stocks.reduce', $stock->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control form-control-sm" min="1"
                                                placeholder="Jumlah" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-success" data-toggle="tooltip"
                                                    title="Kurangi Stok">Kurangi</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Edit and Delete Buttons -->
                                    <div class="mt-2">
                                        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm"
                                            data-toggle="tooltip" title="Edit Stok">Edit</a>
                                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                title="Hapus Stok">Hapus</button>
                                        </form>
                                    </div>
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
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                transition: box-shadow 0.3s ease;
            }

            .custom-table th,
            .custom-table td {
                vertical-align: middle;
            }

            .custom-table .thead-dark {
                background-color: #343a40;
                color: white;
            }

            .btn-sm {
                font-size: 0.875rem;
            }

            .btn-warning {
                background-color: #f39c12;
                border-color: #e67e22;
            }

            .btn-warning:hover {
                background-color: #e67e22;
            }

            .btn-success {
                background-color: #2ecc71;
                border-color: #27ae60;
            }

            .btn-success:hover {
                background-color: #27ae60;
            }

            .btn-danger {
                background-color: #e74c3c;
                border-color: #c0392b;
            }

            .btn-danger:hover {
                background-color: #c0392b;
            }

            .input-group {
                max-width: 200px;
            }

            /* Tooltip Styles */
            .btn-sm[data-toggle="tooltip"]:hover {
                background-color: #2980b9;
            }

            .container-fluid {
                padding-top: 50px;
            }

            /* Ensure the form elements have space between them */
            .input-group-append .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        </style>
    @endsection

    @section('scripts')
        <script>
            // Enable Tooltips
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endsection