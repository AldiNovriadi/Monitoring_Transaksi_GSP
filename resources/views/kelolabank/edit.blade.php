@extends('kelolabank.layout')

@section('title')
    Data Akun Bank
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Edit Data Akun Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Akun Bank</li>
            </ol>
        </nav>
    </div>


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data Akun Bank</h5>
                        <form class="row g-3" method="post" action="/kelolabank/{{ $bank->id }}">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <span class="text-secondary">Nama Bank</span>
                                    <input type="text" name="nama_bank" class="form-control m-input"
                                        value="{{ $bank->nama_bank }}" autocomplete="off"></br>
                                    <span class="text-secondary">Kode Bank</span>
                                    <input type="text" name="kode_bank" class="form-control m-input"
                                        value="{{ $bank->kode_bank }}" autocomplete=" off"></br>
                                    <span class="text-secondary">File Gambar</span>
                                    <input class="form-control" name="filegambar" value="{{ $bank->filegambar }}"
                                        type="file" id="formFile"> </br>
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
