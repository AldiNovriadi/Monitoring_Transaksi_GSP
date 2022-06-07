@extends('transaksi.layout')

@section('title')
    Dashboard
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/voting">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->

                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <a href="/transaksi/listtransaksinonpln">
                                    <h5 class="card-title">Rupiah Tagihan <span>| Hari Ini</span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cursor-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>Rp {{ number_format($transactionRupiah, 0, '', '.') }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Rupiah Tagihan</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                                    <li><a class="dropdown-item" href="/transaksi/month">Bulan ini</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <a href="/transaksi/today">
                                    <h5 class="card-title">Transaksi <span>| Hari ini</span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-reception-4"></i>
                                    </div>
                                    <div class=" ps-3">
                                        <h6>{{ number_format($transactiontoday, 0, '', '.') }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Transaksi</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">


                                    <li><a class="dropdown-item" href="/kelolabank">Data Bank</a></li>
                                    <li><a class="dropdown-item" href="/kelolamitra"> Data Mitra</a></li>
                                    {{-- <li><a class="dropdown-item" href="/kelolabiller">Data Biller</a></li> --}}
                                </ul>
                            </div>

                            <div class="card-body">
                                <a href="/transaksi/listtransaksipln">
                                    <h5 class="card-title">Bank <span>| Mitra </span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $transactionbank }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Bank</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Sales Card -->

                </div>
            </div>
        </div>

    </section>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Transaksi Hari Ini</h5> --}}
                        <div class="card-body">
                            <h5 class="card-title">Reports {{ date('F') }} <span>/bulan</span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                var tanggal = <?php echo $tanggal; ?>;
                                var pln = <?php echo $pln; ?>;

                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'PLN',
                                            data: pln,
                                        }],
                                        chart: {
                                            height: 350,

                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {

                                            categories: tanggal
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy HH:mm'
                                            },
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Reports -->

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "emptyTable": "Hari ini tidak ada transaksi"
                },
                "scrollX": true
            });
        });
    </script>
@endsection
