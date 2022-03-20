@extends('accounting.layout')

@section('title')
    Transaksi
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Hari Ini </h5>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Produk</th>
                                    <th>Lembar</th>
                                    <th>Fee GSP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction as $transactions)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ $transactions->cid->nama_cid }} </td>
                                        <td> {{ $transactions->produk->nama_produk }}</td>
                                        <td> {{ $transactions->rekening }}</td>
                                        <td> Rp. {{ number_format($transactions->rptag) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "emptyTable": "Hari ini tidak ada transaksi"
                },
            });
        });
    </script>
@endsection
