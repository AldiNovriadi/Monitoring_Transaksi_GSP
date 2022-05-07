@extends('layouts.template')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link " href="/mitra">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/mitra/transaksi">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Transaksi Hari Ini</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/mitra/transaksimonth">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Transaksi Per Bulan</span>
        </a>
    </li><!-- End Dashboard Nav -->
@endsection
