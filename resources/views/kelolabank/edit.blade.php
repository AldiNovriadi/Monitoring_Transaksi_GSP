@extends('kelolabank.layout')

@section('title')
   Edit Data Bank
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Edit Data Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Bank</li>
            </ol>
        </nav>
    </div>


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data Bank</h5>
                        <form class="row g-3" method="post" action="/kelolabank/{{ $bank->id }}" enctype="multipart/form-data">
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
                                    <span class="text-secondary">File Template Excel <b>(<span> Template Saat ini : @if(empty($bank->filetemplate)) Belum Ada @else <a href="{{asset('/excelTemplate/'.$bank->filetemplate)}}">{{$bank->filetemplate}}</a> @endif )</b></span>
                                    
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
