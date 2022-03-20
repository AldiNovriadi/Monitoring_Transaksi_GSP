@extends('transaksi.layout')

@section('title')
    Transaksi Hari Ini
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
                        <h5 class="card-title">Transaksi Hari Ini</h5>
                        <p>
                        <form action="/importTransaksi" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control" placeholder="Recipient's username"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
                            </div>
                        </form>
                        </p>
                        <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Tanggal</th>
                                    <th>Distribusi</th>
                                    <th>Mitra</th>
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
                                    {{-- @dd($transaction); --}}
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ $transactions->cid->nama_cid }} </td>
                                        <td> {{ $transactions->kd->nama_kd }}</td>
                                        <td> {{ $transactions->produk->nama_produk }}</td>
                                        <td> {{ $transactions->bank->nama_bank }}</td>
                                        <td> {{ $transactions->rekening }}</td>
                                        <td> {{ $transactions->bulan }}</td>
                                        <td> Rp. {{ number_format($transactions->rptag) }}</td>
                                        <td> Rp. {{ number_format($transactions->rpadm) }}</td>
                                        <td> Rp. {{ number_format($transactions->total) }}</td>
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
