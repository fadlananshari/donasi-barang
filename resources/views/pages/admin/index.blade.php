@extends('layouts.admin')

@section('title', 'Home')

@section('custom_css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection

@section('active-menu-dashboard', 'active')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Box cards (sama seperti sebelumnya, tidak perlu diubah) -->
        <!-- Proposal Donasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Proposal Donasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahProposal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-file-text fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Donasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahDonasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-archive-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komplain -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Komplain</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jumlahKomplain }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-pencil-square fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
          </div>
        </div>
    </div>

@endsection

@section('custom_js')
    <script>
        const chartDataProposal = @json($chartDataProposal);
        const chartDataDonasi = @json($chartDataDonasi);
        const chartDataUser = @json($chartDataUser);
        const chartDataKomplain = @json($chartDataKomplain);

        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('myAreaChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                                {
                                    label: "Proposal",
                                    data: chartDataProposal,
                                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    tension: 0.3,
                                    fill: true,
                                },
                                {
                                    label: "Donasi",
                                    data: chartDataDonasi,
                                    backgroundColor: "rgba(28, 200, 138, 0.05)",
                                    borderColor: "rgba(28, 200, 138, 1)",
                                    pointBackgroundColor: "rgba(28, 200, 138, 1)",
                                    pointBorderColor: "rgba(28, 200, 138, 1)",
                                    pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                                    pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                                    tension: 0.3,
                                    fill: true,
                                },
                                {
                                    label: "Komplain",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(246, 194, 62, 0.05)",
                                    borderColor: "rgba(246, 194, 62, 1)",         
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(246, 194, 62, 1)",
                                    pointBorderColor: "rgba(246, 194, 62, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
                                    pointHoverBorderColor: "rgba(246, 194, 62, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: chartDataKomplain,
                                },
                                {
                                    label: "User",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(13, 202, 240, 0.05)", 
                                    borderColor: "rgba(13, 202, 240, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(13, 202, 240, 1)",
                                    pointBorderColor: "rgba(13, 202, 240, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(13, 202, 240, 1)",
                                    pointHoverBorderColor: "rgba(13, 202, 240, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: chartDataUser,
                                }
                            ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            },
                            ticks: {
                                callback: function (value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                                }
                            }
                        },
                        legend: {
                            display: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
