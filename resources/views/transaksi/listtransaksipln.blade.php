@extends('transaksi.layout')

@section('title')
    Transaksi Hari Ini
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi Hari Ini</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Dashboard</a></li>
                <li class="breadcrumb-item active">Transaksi Hari Ini</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($bank as $banks)
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
                                    <a href="/transaksi/detailmitra/{{ $banks->kode_bank }}">
                                        <h5 class="card-title">{{ $banks->nama_bank }} <span>| Hari ini</span></h5>
                                    </a>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                            {{-- <img src="{{ asset('/assets/img/' . $banks->filegambar) }}" alt=""> --}}
                                        </div>
                                        <div class="ps-3">
                                            {{-- {{ number_format($transactiontoday, 0, '', '.') }} --}}
                                            <h6>{{ number_format($banks->transaction()->Valid()->whereDate('created_at', date('Y-m-d'))->sum('bulan'),0,'','.') }}
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
