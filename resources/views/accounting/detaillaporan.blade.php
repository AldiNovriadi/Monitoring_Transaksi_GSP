@extends('accounting.layout')

@section('title')
    Laporan Bulanan
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Laporan Bulanan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/accounting">Home</a></li>
                <li class="breadcrumb-item"><a href="/accounting/laporan">Laporan Bulanan</a></li>
                <li class="breadcrumb-item active">Detail Laporan Bulanan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Bulan {{$month}} {{$year}}</h5>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Mitra</th>
                                    <th>Produk</th>
                                    <th>Lembar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction as $transactions)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ \App\Models\Cid::where('kode_cid', $transactions->cid_id)->first()->nama_cid }}
                                        </td>
                                        <td> {{ \App\Models\Produk::where('kode_produk', $transactions->produk_id)->first()->nama_produk }}
                                        </td>
                                        <td> {{ $transactions->lembar }}</td>
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
                    "emptyTable": "Bulan ini tidak ada transaksi"
                },
            });
        });
    </script>
@endsection
