@extends('layouts.template')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link " href="/accounting">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->


    <li class="nav-item">
        <a class="nav-link " href="/accounting/laporan">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Laporan Bulanan</span>
        </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Kelola Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="/accounting/transaksi">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Hari Ini</span>
                </a>
            </li>
            <li>
                <a href="/accounting/detailtransaksi">
                    <i class="ri-arrow-right-circle-fill"></i><span>Detail Transaksi</span>
                </a>
            </li>
            <li>
                <a href="/accounting/filter">
                    <i class="ri-arrow-right-circle-fill"></i><span>Filtering Transaksi</span>
                </a>
            </li>
        </ul>
    </li><!-- End Tables Nav -->
@endsection
