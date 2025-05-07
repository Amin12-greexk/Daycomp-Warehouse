<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            justify-content: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header .company-name {
            font-size: 32px;
            color: #000;
            margin: 0;
            font-weight: bold;
        }
        .header .tagline {
            font-size: 16px;
            color: #333;
            margin: 0;
        }
        .header .contact-info {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #000;
            margin-bottom: 40px;
            table-layout: fixed;
            word-wrap: break-word;
            
        }

        th, td {
            padding: 7px 7px;
            font-size: 9px;
            border: 1px solid #000;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: transparent;
            color: #000;
            font-weight: bold;
        }

        td {
            background-color: transparent;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 30px;
        }

        .divider {
            border-top: 2px solid #000;
            margin: 20px 0;
        }

        .content-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media print {
            table {
                font-size: 8px;
            }

            th, td {
                padding: 4px;
            }
        }
    </style>
</head>
<body>

    <div class="content-wrapper">
        <div class="header">
            <h1 class="company-name">Daycomp</h1>
            <p class="tagline">Sistem Manajemen Produk dan Stok</p>
            <p class="contact-info">
                Jalan Getassrabi No. 1, Gebog, Kudus, Indonesia | Telp: +62 21 1234 5678 | Email: daycomp@gmail.com
            </p>
        </div>

        <table>
            <tr>
                <th>Nama Produk</th>
                <th>Kode Produk</th>
                <th>Kategori</th>
                <th>Pemasok</th>
                <th>Gudang</th>
                <th>Harga Pembelian</th>
                <th>Harga Jual</th>
                <th>Tanggal Dibuat</th>
                <th>ID Stok</th>
                <th>Jenis Pembaruan Stok</th>
                <th>Jumlah</th>
                <th>Tanggal Pembaruan Stok</th>
            </tr>
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->product_code }}</td>
                <td>{{ $category }}</td>
                <td>{{ $supplier }}</td>
                <td>{{ $warehouse }}</td>
                <td>Rp {{ number_format($product->purchase_price, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($product->sale_price, 2, ',', '.') }}</td>
                <td>{{ $created_at }}</td>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock_type }}</td>
                <td>{{ $quantity }}</td>
                <td>{{ $stock_date }}</td>
            </tr>
        </table>

    </div>

</body>
</html>
