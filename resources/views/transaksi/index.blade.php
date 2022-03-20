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
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="/transaksi/month">Bulan ini</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <a href="/transaksi/today">
                                    <h5 class="card-title">Transaksi <span>| Hari ini</span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class=" ps-3">
                                        <h6>{{ $transactiontoday }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Transaksi</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="/kelolabank">Data Bank</a></li>

                                </ul>
                            </div>

                            <div class="card-body">
                                <a href="/transaksi/listtransaksipln">
                                    <h5 class="card-title">Bank <span>| Mitra </span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
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
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="/kelolabiller">Data Biller</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <a href="/transaksi/listtransaksinonpln">
                                    <h5 class="card-title">Biller <span>| Mitra</span></h5>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $transactionbiller }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Biller</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

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
                                var non_pln = <?php echo $non_pln; ?>;

                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'PLN',
                                            data: pln,
                                        }, {
                                            name: 'Non PLN',
                                            data: non_pln
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
                {{-- <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Distribusi</th>
                                    <th>Produk</th>
                                    <th>Pelanggan</th>
                                    <th>Lembar</th>
                                    <th>Bulan</th>
                                    <th>Rupiah Tagihan</th>
                                    <th>Rupiah Admin</th>
                                    <th>Rupiah Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction as $transactions)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ $transactions->cid->nama_cid }} </td>
                                        <td> {{ $transactions->kd->nama_kd }}</td>
                                        <td> {{ $transactions->produk->nama_produk }}</td>
                                        <td> {{ $transactions->bank->nama_bank }}</td>
                                        <td> {{ $transactions->rekening }}</td>
                                        <td> {{ $transactions->bulan }}</td>
                                        <td> Rp. {{ number_format($transactions->rptag) }}</td>
                                        <td> Rp. {{ number_format($transactions->rpadm) }}</td>
                                        <td> Rp. {{ number_format($transactions->total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
            </div>
        </div>
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
