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
                    @foreach ($billermonth as $billermonths)
                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">


                                <div class="card-body">
                                    <a href="/transaksi/detailbillermonth/{{ $billermonths->kode_biller }}">
                                        <h5 class="card-title">{{ $billermonths->nama_biller }} <span>| Bulan
                                                ini</span>
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
                                            <h6>{{ $billermonths->transactionbiller->count() }}
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
