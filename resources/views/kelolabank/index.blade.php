@extends('layouts.template')

@section('title')
    Data Bank
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Data Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Data Bank</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Bank</h5>
                        <p><a href="/kelolabank/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah
                                    Data
                                    Bank
                                </button></a> </p>
                        <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Nama</th>
                                    <th>Kode Bank</th>
                                    <th>File Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bank as $banks)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $banks->nama_bank }} </td>
                                        <td> {{ $banks->kode_bank }}</td>
                                        <td> {{ $banks->filegambar }}</td>
                                        <td class="text-center">
                                            <a href="/kelolabank/{{ $banks->id }}/edit/" class="btn btn-warning"
                                                style="display: inline-block;"> <i class="bx bx-edit"></i></a>
                                            <form action="/kelolabank/{{ $banks->id }}" method="post"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </form>
                                        </td>
                                        {{-- <td class="text-center">
                                            <button style="display: inline-block;" class="btn btn-success"
                                                href="/bank/edit"> <i class="bx bx-edit"></i></button>
                                            <form style="display: inline-block;" action="/Bank/{{ $Banks->id }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </form>
                                        </td> --}}
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
