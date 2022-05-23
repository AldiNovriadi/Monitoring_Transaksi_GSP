@extends('kelolamitra.layout')

@section('title')
Data Mitra
@endsection

<?php $no = 1; ?>
@section('content')
@include('sweetalert::alert')
<div class="pagetitle">
    <h1>Tambah Data Mitra</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
            <li class="breadcrumb-item active">Tambah Data Mitra</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Data Mitra</h5>
                    <form class="row g-3" method="post" action="/kelolamitra" enctype="multipart/form-data">
                        @csrf
                        <div class="col-lg-12">
                            <div id="inputFormRow">
                                <span class="text-secondary">Nama Mitra</span>
                                <input type="text" name="nama_cid" class="form-control m-input" placeholder="Masukkan Nama Mitra" autocomplete="off" required></br>
                                <span class="text-secondary">Kode Mitra</span>
                                <input type="text" name="kode_cid" class="form-control m-input" placeholder="Masukkan Kode Mitra" autocomplete="off" required></br>
                                <span class="text-secondary">Bank</span>
                                <select name="bank_id" class="form-select" id="pilihBank" required>
                                    <option selected disabled value="">-- Masukkan Bank --</option>
                                    @foreach ($bank as $banks)
                                    <option value="{{ $banks->kode_bank }}"> {{ $banks->nama_bank }} </option>
                                    @endforeach
                                </select> </br>
                                <div id="checkAggregator">
                                    <span class="text-secondary">Mitra Aggregator</span>
                                    <div class="form-check">
                                        <input id="gridCheck2" type="checkbox" name="is_aggregator" class="form-check-input" value="aggregator">
                                        <label for="gridCheck2" class="form-check-label">Checklist jika Aggregator</label>
                                    </div>
                                    <br>
                                </div>
                                
                                <span class="text-secondary">File Template Excel </span>
                                <input class="form-control" name="filtetemplate" type="file" id="formFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> </br>

                            </div>
                        </div>
                        <p align="right">
                            <button type="submit" class="btn btn-primary" style="width:15%">Simpan
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $('#checkAggregator').hide();

    $(document).on('change','#pilihBank',function(){
        if($(this).val()=="9"){
            $('#checkAggregator').show();
        }else{
            $('#gridCheck2').prop('checked', false);
            $('#checkAggregator').hide();
           
        }
    });
</script>
@endsection