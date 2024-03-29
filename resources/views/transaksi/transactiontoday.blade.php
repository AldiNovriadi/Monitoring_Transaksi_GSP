@extends('transaksi.layout')

@section('title')
    Transaksi Hari Ini
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Import Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Import Transaksi</li>
            </ol>
        </nav>
    </div>
    @include('layouts.notif')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Import Transaksi</h5>
                        <form action="/importTransaksi" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control" placeholder="Recipient's username"
                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hasil Import Transaksi</h5>

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
                                    <th>Diimport Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPelanggan = 0;
                                    $totalLembar = 0;
                                    $totalRpTag = 0;
                                    $totalRpAdmin = 0;
                                    $totalRpTotal = 0;
                                @endphp
                                @foreach ($transactionPending as $transactions)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ @$transactions->cid->nama_cid }} </td>
                                        <td> {{ @$transactions->kd->nama_kd }}</td>
                                        <td> {{ @$transactions->produk->nama_produk }}</td>
                                        <td> {{ @$transactions->bank->nama_bank }}</td>
                                        <td> {{ $transactions->rekening }}</td>
                                        <td> {{ $transactions->bulan }}</td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->rptag, 0, '', '.') }}</td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->rpadm, 0, '', '.') }}</td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->total, 0, '', '.') }}</td>
                                        <td>{{ @$transactions->getCreatedBy->name }}</td>
                                    </tr>
                                    @php
                                        $totalPelanggan += $transactions->rekening;
                                        $totalLembar += $transactions->bulan;
                                        $totalRpTag += $transactions->rptag;
                                        $totalRpAdmin += $transactions->rpadm;
                                        $totalRpTotal += $transactions->total;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Validasi</h5>
                        <button class="btn btn-primary" id="btnValidate"
                            {{ count($transactionPending) < 1 ? 'disabled' : '' }}>Konfirmasi</button>
                        <button class="btn btn-danger" id="btnHapus"
                            {{ count($transactionPending) < 1 ? 'disabled' : '' }}>Hapus Data</button>
                        <br><br>
                        <table id="example8" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>Pelanggan</th>
                                    <th>Lembar</th>
                                    <th>Rupiah Tagihan</th>
                                    <th>Rupiah Admin</th>
                                    <th>Rupiah Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> {{ number_format($totalPelanggan, 0, '', '.') }}</td>
                                    <td> {{ number_format($totalLembar, 0, '', '.') }}</td>
                                    <td class="text-end"> Rp {{ number_format($totalRpTag, 0, '', '.') }}</td>
                                    <td class="text-end"> Rp {{ number_format($totalRpAdmin, 0, '', '.') }}</td>
                                    <td class="text-end"> Rp {{ number_format($totalRpTotal, 0, '', '.') }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Final Transaksi</h5>
                        <table id="example2" class="table table-striped table-bordered display nowrap" style="width:100%">
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
                                    <th>Diimport Oleh</th>
                                    <th>Divalidasi Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactionFix as $transactions)
                                    {{-- @dd($transaction); --}}
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $transactions->tanggal }} </td>
                                        <td> {{ @$transactions->kd->nama_kd }}</td>
                                        <td> {{ @$transactions->cid->nama_cid }} </td>
                                        <td> {{ @$transactions->produk->nama_produk }}</td>
                                        <td> {{ @$transactions->bank->nama_bank }}</td>
                                        <td> {{ $transactions->rekening }}</td>
                                        <td> {{ $transactions->bulan }}</td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->rptag, 0, '', '.') }}
                                        </td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->rpadm, 0, '', '.') }}
                                        </td>
                                        <td class="text-end"> Rp. {{ number_format($transactions->total, 0, '', '.') }}
                                        </td>
                                        <td>{{ @$transactions->getCreatedBy->name }}</td>
                                        <td>{{ @$transactions->getValidateBy->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalValidate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/validateTransaction">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        Dengan ini,Transaksi ini akan di validasi dan tidak akan bisa diubah lagi
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/deletePendingTransaction">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Dengan ini,Transaksi ini akan dihapus dari database
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

            $('#example2').DataTable({
                "language": {
                    "emptyTable": "Hari ini tidak ada transaksi"
                },
                "scrollX": true
            });

            $('#btnValidate').on('click', function() {
                $('#modalValidate').modal('show');
            })

            $('#btnHapus').on('click', function() {
                $('#modalHapus').modal('show');
            })
        });
    </script>
@endsection
