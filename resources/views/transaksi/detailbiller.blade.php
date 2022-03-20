@extends('transaksi.layout')

@section('title')
    Transaksi {{ $biller->nama_biller }}
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Transaksi {{ $biller->nama_biller }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Transaksi {{ $biller->nama_biller }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi {{ $biller->nama_biller }}</h5>
                        <p><a href="/mitra/create"> <button id="addRow" type="submit" class="btn btn-primary">
                                    <i class="ri-file-excel-2-fill"> </i> Export Laporan
                                </button></a> </p>
                        <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Biller</th>
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
                                @foreach ($transbiller as $transbillers)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td>{{ $transbillers->tanggal }}</td>
                                        <td>{{ $transbillers->cid->nama_cid }}</td>
                                        <td>{{ $transbillers->biller->nama_biller }}</td>
                                        <td>{{ $transbillers->Produk->nama_produk }}</td>
                                        <td>{{ $transbillers->Bank->nama_bank }}</td>
                                        <td>{{ $transbillers->rekening }}</td>
                                        <td>{{ $transbillers->bulan }}</td>
                                        <td> Rp. {{ number_format($transbillers->rptag) }}</td>
                                        <td> Rp. {{ number_format($transbillers->rpadm) }}</td>
                                        <td> Rp. {{ number_format($transbillers->total) }}</td>
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
