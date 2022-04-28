@extends('layouts.template')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link " href="/transaksi">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link " href="/account">
            <i class="bi bi-journal-text"></i>
            <span>Data Akun</span>
        </a>
    </li><!-- End Components Nav -->

    {{-- <li class="nav-item">
    <a class="nav-link " href="/transaksi/listtransaksipln">
        <i class="bi bi-layout-text-window-reverse"></i>
        <span>Transaksi PLN</span>
    </a>
</li><!-- End Components Nav --> --}}

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pln-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>Transaksi PLN</span><i
                class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pln-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="/transaksi/listtransaksipln">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Hari ini</span>
                </a>
            </li>
            <li>
                <a href="/transaksi/listtransaksiplnmonth">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Bulan ini</span>
                </a>
            </li>
        </ul>
    </li><!-- End Tables Nav -->


    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#nonpln-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>Transaksi Non PLN</span><i
                class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nonpln-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="/transaksi/listtransaksinonpln">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Hari ini</span>
                </a>
            </li>
            <li>
                <a href="/transaksi/listtransaksinonplnmonth">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Bulan ini</span>
                </a>
            </li>
        </ul>
    </li><!-- End Tables Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Kelola Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="/transaksi/filter">
                    <i class="ri-arrow-right-circle-fill"></i><span>Filtering Transaksi</span>
                </a>
            </li>
            <li>
                <a href="/transaksi/today">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Hari
                        ini</span>
                </a>
            </li>
            <li>
                <a href="/transaksi/month">
                    <i class="ri-arrow-right-circle-fill"></i><span>Transaksi Bulan ini</span>
                </a>
            </li>
        </ul>
    </li><!-- End Tables Nav -->
@endsection
