<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logogsp.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="/voting" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logogsp.png') }}" style="width: 20%" alt="">
                <span class="d-none d-lg-block" style="font-size: 100%">PT. Gerbang Sinergi Prima </span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar --> --}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="ri-account-circle-line" style="font-size: 220%"> </i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->name }}</h6>
                            <span>Account</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="/logout" method="post">
                                @csrf
                                <a class="dropdown-item d-flex align-items-center"
                                    onclick="this.closest('form').submit()">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav>


    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="/transaksi">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link " href="/mitra">
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
                    <i class="bi bi-menu-button-wide"></i><span>Kelola Transaksi</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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

        </ul>
    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        @yield("content")
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Aldi Novriadi</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @yield('script')
</body>


</html>
