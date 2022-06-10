@extends('transaksi.layout')

@section('title')
    Transaksi PLN
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi PLN</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Dashboard</a></li>
                <li class="breadcrumb-item active">Transaksi PLN</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($bankmonth as $bankmonths)
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
                                    <a href="/transaksi/detailmitramonth/{{ $bankmonths->kode_bank }}">
                                        <h5 class="card-title">{{ $bankmonths->nama_bank }} <span>| Bulan ini</span>
                                        </h5>
                                    </a>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                            {{-- <img src="{{ asset('/assets/img/' . $bankmonths->filegambar) }}" alt=""> --}}
                                        </div>
                                        <div class="ps-3">
                                            {{-- @dd($bankmonths); --}}
                                            <h6>{{ number_format($bankmonths->transaction->sum('bulan'), 0, '', '.') }}
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
