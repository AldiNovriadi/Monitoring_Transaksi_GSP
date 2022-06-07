@extends('bank.layout')

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
            <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
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

                    <p><a href="/file-export/{{ $bank->kode_bank }}"> <button id="addRow" type="submit" class="btn btn-primary">
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
                            @foreach ($trans as $tran)
                            <tr>
                                <td class="text-center"> <?php echo $no++; ?> </td>
                                <td>{{ $tran->tanggal }}</td>
                                <td>{{ $tran->cid->nama_cid }}</td>
                                <td>{{ $tran->kd->nama_kd }}</td>
                                <td>{{ $tran->Produk->nama_produk }}</td>
                                <td>{{ $tran->Bank->nama_bank }}</td>
                                <td>{{ $tran->rekening }}</td>
                                <td>{{ $tran->bulan }}</td>
                                <td> Rp. {{ number_format($tran->rptag, 0, '', '.') }}</td>
                                <td> Rp. {{ number_format($tran->rpadm, 0, '', '.') }}</td>
                                <td> Rp. {{ number_format($tran->total, 0, '', '.') }}</td>
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