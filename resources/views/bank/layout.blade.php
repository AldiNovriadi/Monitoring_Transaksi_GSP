@extends('layouts.template')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link " href="/bank">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/bank/transaksi">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Transaksi Hari Ini</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/bank/transaksimonth">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Transaksi Per Bulan</span>
        </a>
    </li><!-- End Dashboard Nav -->
@endsection
