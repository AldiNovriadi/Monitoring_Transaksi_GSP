@extends('kelolabank.layout')

@section('title')
    Data Bank
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Tambah Data Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Tambah Data Bank</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Bank</h5>
                        <form class="row g-3" method="post" action="/kelolabank" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <span class="text-secondary">Nama Bank</span>
                                    <input type="text" name="nama_bank" class="form-control m-input"
                                        placeholder="Masukkan Nama Bank" autocomplete="off" required></br>
                                    <span class="text-secondary">Kode Bank</span>
                                    <input type="text" name="kode_bank" class="form-control m-input"
                                        placeholder="Masukkan Kode Bank" autocomplete="off" required></br>
                                    <span class="text-secondary">File Template Excel </span>
                                    <input class="form-control" name="filtetemplate" type="file" id="formFile"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" > </br>
                                    
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
