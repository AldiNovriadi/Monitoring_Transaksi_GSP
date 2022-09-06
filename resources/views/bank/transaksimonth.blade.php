@extends('bank.layout')

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
                <li class="breadcrumb-item active">Transaksi Bulan ini</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Bulan Ini </h5>
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
                                @foreach ($transaction as $transactions)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ $transactions->cid->nama_cid }} </td>
                                        <td> {{ $transactions->kd->nama_kd }} </td>
                                        <td> {{ $transactions->produk->nama_produk }}</td>
                                        <td>{{ $transactions->Bank->nama_bank }}</td>
                                        <td>{{ number_format($transactions->rekening, 0, '', '.') }}</td>
                                        <td>{{ number_format($transactions->bulan, 0, '', '.') }}</td>
                                        <td class="text-end"> Rp {{ number_format($transactions->rptag, 0, '', '.') }}</td>
                                        <td class="text-end"> Rp {{ number_format($transactions->rpadm, 0, '', '.') }}</td>
                                        <td class="text-end"> Rp {{ number_format($transactions->total, 0, '', '.') }}</td>
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
