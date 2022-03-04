@extends('layouts.template')

@section('title')
    Data Akun
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Tambah Akun Mitra</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Tambah Akun Mitra</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Akun Mitra</h5>
                        <form class="row g-3" method="post" action="/mitra">
                            @csrf
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <span class="text-secondary">Nama</span>
                                    <input type="text" name="name" class="form-control m-input" placeholder="Masukkan Nama"
                                        autocomplete="off"></br>
                                    <span class="text-secondary">Email</span>
                                    <input type="text" name="email" class="form-control m-input"
                                        placeholder="Masukkan Email" autocomplete="off"></br>
                                    <span class="text-secondary">Role</span>
                                    <select name="role" class="form-select" aria-label="Default select example">
                                        <option selected>-- Masukkan Role --</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select> </br>
                                    <span class="text-secondary">Status</span>
                                    <input type="text" name="status" class="form-control m-input"
                                        placeholder="Masukkan Status" autocomplete="off"></br>
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
