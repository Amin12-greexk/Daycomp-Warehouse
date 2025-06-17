@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title"><i class="icon-home me-2"></i>Dashboard</h1>

        <!-- Statistics Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <a href="{{ route('products.index') }}" class="stat-card bg-blue">
                    <div class="card-body text-center">
                        <h5><i class="icon-list me-2"></i>Total Products</h5>
                        <p class="count">{{ $totalProducts }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('categories.index') }}" class="stat-card bg-red">
                    <div class="card-body text-center">
                        <h5><i class="icon-tag me-2"></i>Total Categories</h5>
                        <p class="count">{{ $totalCategories }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('stocks.index') }}" class="stat-card bg-blue">
                    <div class="card-body text-center">
                        <h5><i class="icon-layers me-2"></i>Total Stocks</h5>
                        <p class="count">{{ $totalStocks }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('warehouses.index') }}" class="stat-card bg-red">
                    <div class="card-body text-center">
                        <h5><i class="icon-home me-2"></i>Total Warehouses</h5>
                        <p class="count">{{ $totalWarehouses }}</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto chart-container">
                <h4 class="text-center"><i class="cil-chart-pie me-2"></i>Stock Distribution</h4>
                <canvas id="stockCategoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('stockCategoryChart').getContext('2d');

            fetch("{{ route('chart.data') }}")
                .then(response => response.json())
                .then(data => {
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Stock Distribution',
                                data: data.data,
                                backgroundColor: ['#007bff', '#e74c3c', '#ff5733', '#8e44ad'],
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error));
        });
    </script>

    <style>
        /* General Dashboard Styling */
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #34495e;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeInDown 1s ease-in-out;
        }

        /* Statistic Cards */
        .stat-card {
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-body {
            padding: 20px;
            color: white;
        }

        .stat-card h5 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .stat-card .count {
            font-size: 2.5rem;
            font-weight: bold;
            animation: countUp 1.5s ease-in-out;
        }

        .bg-blue {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .bg-red {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Chart Styling */
        .chart-container {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            animation: fadeInUp 1s ease-in-out;
        }

        .chart-container:hover {
            transform: scale(1.02);
        }

        #stockCategoryChart {
            max-height: 300px;
            width: 100%;
        }

        /* Animations */
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

        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
@endsection