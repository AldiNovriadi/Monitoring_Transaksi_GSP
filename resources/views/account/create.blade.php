@extends('account.layout')

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
                        <form class="row g-3" method="post" action="/account">
                            @csrf
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                <span class="text-secondary">Role</span>
                                    <select name="role" id="select_role" class="form-select" aria-label="Default select example">
                                        <option selected disabled>-- Masukkan Role --</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Mitra">Mitra</option>
                                    </select> </br>
                                    <div id="list_bank">
                                    <span class="text-secondary">Bank</span>
                                    <select name="bank_id" id="select_bank" class="form-select" aria-label="Default select example">
                                        <option selected disabled>-- Masukkan Bank --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}"> {{ $bank->nama_bank }} </option>
                                        @endforeach
                                    </select> </br>
                                    </div>
                                    <div id="list_mitra">
                                    <span class="text-secondary">Mitra</span>
                                    <select name="mitra_id" id="select_mitra" class="form-select" aria-label="Default select example">
                                        <option selected disabled>-- Masukkan Mitra --</option>
                                        @foreach ($mitras as $mitra)
                                            <option value="{{ $mitra->id }}"> {{ $mitra->nama_cid }} </option>
                                        @endforeach
                                    </select> </br>
                                    </div>
                                    <span class="text-secondary">Nama</span>
                                    <input type="text" name="name" class="form-control m-input" placeholder="Masukkan Nama"
                                        autocomplete="off"></br>
                                    <span class="text-secondary">Email</span>
                                    <input type="text" name="email" class="form-control m-input"
                                        placeholder="Masukkan Email" autocomplete="off"></br>
                                    
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
        $(document).ready(function(){
            $('#list_bank').hide();
            $('#list_mitra').hide();
            $('#select_role').on('change',function(){
                $('#list_bank').hide();
                $('#list_mitra').hide();
                $('#select_bank').removeAttr('required');
                $('#select_mitra').removeAttr('required');
                $('#select_bank').val('');
                $('#select_mitra').val('');
                if($(this).val() == 'Bank'){
                    $('#select_bank').prop('required','required');
                    $('#list_bank').show();
                }else if($(this).val() == 'Mitra'){
                    $('#select_mitra').prop('required','required');
                    $('#list_mitra').show();    
                }
            });
        })
    
    </script>

@endsection
