@extends('transaksi.layout')

@section('title')
    Transaksi Non PLN
@endsection

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi Non PLN</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Dashboard</a></li>
                <li class="breadcrumb-item active">Transaksi Non PLN</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($biller as $billers)
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
                                    <a href="/transaksi/detailbiller/{{ $billers->kode_biller }}">
                                        <h5 class="card-title">{{ $billers->nama_biller }} <span>| Hari ini</span>
                                        </h5>
                                    </a>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                            {{-- <img src="{{ asset('/assets/img/' . $billers->filegambar) }}" alt=""> --}}
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $billers->transactionbiller()->whereDate('created_at', date('Y-m-d'))->count() }}
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
