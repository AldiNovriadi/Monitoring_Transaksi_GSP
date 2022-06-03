@extends('accounting.layout')

@section('title')
Filtering Transaksi
@endsection

<?php $no = 1; ?>
@section('content')
@include('sweetalert::alert')
<div class="pagetitle">
    <h1>Filtering Transaksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/accounting">Home</a></li>
            <li class="breadcrumb-item active">Filtering Transaksi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filtering Transaksi</h5>
                    <form class="row g-3" method="get">
                        <div class="col-lg-12">
                            <div id="inputFormRow">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-secondary">Tanggal Mulai</span>
                                        <input type="date" id="tanggalawal" name="tanggalawal" class="form-control" placeholder="Enter Time" value="{{ Request::get('tanggalawal') }}">
                                    </div>
                                    <div class=" col-md-6">
                                        <span class="text-secondary">Tanggal Akhir</span>
                                        <input type="date" id="tanggalakhir" name="tanggalakhir" class="form-control" placeholder="Enter Time" value="{{ Request::get('tanggalakhir') }}" {{ empty(Request::get('tanggalakhir')) ? 'disabled' : '' }}>
                                    </div>
                                </div> </br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-secondary">Bank</span>
                                        <select name="bank" class="form-select" aria-label=" Default select example" id="selectBank" value="{{ Request::get('bank') }}">
                                            <option selected value=''>-- Pilih Bank --</option>
                                            @foreach ($bank as $banks)
                                            <option value="{{ $banks->kode_bank }}" {{ $banks->kode_bank == Request::get('bank') ? 'selected' : '' }}>
                                                {{ $banks->nama_bank }}
                                            </option>
                                            @endforeach
                                        </select> </br>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="text-secondary">Mitra</span>
                                        <select name="mitra" class="form-select" aria-label="Default select example" id="selectMitra">
                                            <option selected value=''>-- Pilih Mitra --</option>
                                            @if(!empty($list_mitra))
                                            @foreach ($list_mitra as $mitra)
                                            <option value="{{ $mitra->kode_cid }}" class="mitraOption" {{ $mitra->kode_cid == Request::get('mitra') ? 'selected' : '' }}>
                                                {{ $mitra->nama_cid }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select> </br>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-secondary">Produk</span>
                                        <select name="produk" class="form-select" id="selectProduk" aria-label="Default select example">
                                            <option selected value=''>-- Pilih Produk --</option>
                                            @if(!empty($list_produk))

                                            @foreach ($list_produk as $produk)
                                            <option value="{{ $produk->produk->kode_produk }}" class="produkOption" {{ $produk->produk->kode_produk == Request::get('produk') ? 'selected' : '' }}>
                                                {{ $produk->produk->nama_produk }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p align="right">
                            <button type="submit" class="btn btn-primary" style="width:15%">Search
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body"> </br>
                    <p><a href="/file-exportaccounting?tanggalawal={{ Request::get('tanggalawal') }}&tanggalakhir={{ Request::get('tanggalakhir') }}&bank={{ Request::get('bank') }}&mitra={{ Request::get('mitra') }}&produk={{ Request::get('produk') }}">
                            <button id="addRow" type="submit" class="btn btn-primary">
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

    $(document).on('change', '#tanggalawal', function() {
        if ($('#tanggalawal').val() == null) {
            $('#tanggalakhir').attr('disabled');
        } else {
            $('#tanggalakhir').removeAttr('disabled');
        }
    });

    $(document).on('change', '#selectBank', function() {
        $('.produkOption').remove();
        $('.mitraOption').remove();
        $.get('/bank/' + $(this).val() + '/getMitra', function(data) {
            $.each(data.mitra, function(index, value) {
                $('#selectMitra').append(
                    '<option class="mitraOption" value="' + data.mitra[index].kode_cid + '">' + data.mitra[index].nama_cid + '</option>'
                );
            });
        })
        $('#selectMitra').removeAttr('disabled');
    });

    $(document).on('change', '#selectMitra', function() {
        $('.produkOption').remove();
        $.get('/mitra/' + $(this).val() + '/getProduk', function(data) {
            console.log(data.produk);
            $.each(data.produk, function(index, value) {
                console.log(data.produk);
                $('#selectProduk').append(
                    '<option class="produkOption" value="' + data.produk[index].produk.kode_produk + '">' + data.produk[index].produk.nama_produk + '</option>'
                );
            });
        });
        $('#selectProduk').removeAttr('disabled');
    });
</script>
@endsection