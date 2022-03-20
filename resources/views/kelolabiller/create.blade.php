@extends('kelolabiller.layout')

@section('title')
    Data Biller
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Tambah Data Biller</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Tambah Data Biller</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Biller</h5>
                        <form class="row g-3" method="post" action="/kelolabiller">
                            @csrf
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <span class="text-secondary">Nama Biller</span>
                                    <input type="text" name="nama_biller" class="form-control m-input"
                                        placeholder="Masukkan Nama biller" autocomplete="off"></br>
                                    <span class="text-secondary">Kode Biller</span>
                                    <input type="text" name="kode_biller" class="form-control m-input"
                                        placeholder="Masukkan Kode biller" autocomplete="off"></br>
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
