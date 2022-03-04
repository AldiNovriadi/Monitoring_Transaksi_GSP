@extends('layouts.template')

@section('title')
    Data Akun
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Data Akun</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Data Akun</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Akun Mitra</h5>
                        <p><a href="/mitra/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah Data
                                    Mitra
                                </button></a> </p>
                        <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mitra as $mitras)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $mitras->name }} </td>
                                        <td> {{ $mitras->email }}</td>
                                        <td> {{ $mitras->role }}</td>
                                        <td> {{ $mitras->status }} </td>
                                        <td class="text-center">
                                            <a href="/mitra/{{ $mitras->id }}/edit/" class="btn btn-warning"
                                                style="display: inline-block;"> <i class="bx bx-edit"></i></a>
                                            <form action="/mitra/{{ $mitras->id }}" method="post"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </form>
                                        </td>
                                        {{-- <td class="text-center">
                                            <button style="display: inline-block;" class="btn btn-success"
                                                href="/mitra/edit"> <i class="bx bx-edit"></i></button>
                                            <form style="display: inline-block;" action="/mitra/{{ $mitras->id }}"
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
