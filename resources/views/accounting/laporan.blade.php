@extends('accounting.layout')

@section('title')
    Laporan Bulanan
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Laporan Bulanan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/accounting">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Bulanan</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($bankmonths as $bankmonth)
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

                                        <li><a class="dropdown-item" href="#">Semua Transaksi</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <a
                                        href="/accounting/monthReport?month={{ $bankmonth['kd_bulan'] }}&year={{ date('Y') }}">
                                        <h5 class="card-title">{{ $bankmonth['bulan'] }} <span>| Laporan</span>
                                        </h5>
                                    </a>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                            {{-- <img src="{{ asset('/assets/img/' . $bankmonths->filegambar) }}" alt=""> --}}
                                        </div>
                                        <div class="ps-3">
                                            <h6> {{ number_format($bankmonth['jumlah'], 0, '', '.') }}
                                            </h6>
                                            <span class="text-muted small pt-2 ps-1">Transaksi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Sales Card -->
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
