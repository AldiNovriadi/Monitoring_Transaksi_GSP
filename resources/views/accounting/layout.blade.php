@extends('layouts.template')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link " href="/accounting">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/accounting/transaksi">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Transaksi</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/accounting/detailtransaksi">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Detail Transaksi</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/accounting/laporan">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Laporan Bulanan</span>
        </a>
    </li><!-- End Dashboard Nav -->
@endsection
