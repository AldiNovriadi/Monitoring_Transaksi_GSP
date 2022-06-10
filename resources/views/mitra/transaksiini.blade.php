@extends('mitra.layout')

@section('title')
    Transaksi
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi Hari Ini</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/mitra">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Hari Ini</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Hari Ini </h5>
                        <p><a href="/mitra/exportTransaksi"> <button id="addRow" type="submit" class="btn btn-primary">
                                    <i class="ri-file-excel-2-fill"> </i> Export Laporan
                                </button></a> </p>

                        <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Distribusi</th>
                                    <th>Produk</th>
                                    <th>Bank</th>
                                    <th>Pelanggan</th>
                                    <th>Lembar</th>
                                    <th>Rupiah Tagihan</th>
                                    <th>Rupiah Admin</th>
                                    <th>Rupiah Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> {{ $transaction->tanggal }} </td>
                                        <td> {{ $transaction->cid->nama_cid }} </td>
                                        <td> {{ $transaction->kd->nama_kd }}</td>
                                        <td> {{ $transaction->produk->nama_produk }}</td>
                                        <td> {{ $transaction->bank->nama_bank }}</td>
                                        <td> {{ number_format($transaction->rekening, 0, '', '.') }}</td>
                                        <td> {{ number_format($transaction->bula, 0, '', '.') }}</td>
                                        <td> Rp {{ number_format($transaction->rptag, 0, '', '.') }}</td>
                                        <td> Rp {{ number_format($transaction->rpadm, 0, '', '.') }}</td>
                                        <td> Rp {{ number_format($transaction->total, 0, '', '.') }}</td>
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
                "scrollX": true
            });
        });
    </script>
@endsection
