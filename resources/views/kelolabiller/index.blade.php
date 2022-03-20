@extends('kelolabiller.layout')

@section('title')
    Kelola Data Biller
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Kelola Data Biller</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Kelola Data Biller</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Data Biller</h5>
                        <p><a href="/kelolabiller/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah
                                    Data Biller
                                </button></a> </p>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Nama</th>
                                    <th>Kode Biller</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($biller as $billers)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $billers->nama_biller }} </td>
                                        <td> {{ $billers->kode_biller }}</td>
                                        <td class="text-center">
                                            <a href="/kelolabiller/{{ $billers->id }}/edit/" class="btn btn-warning"
                                                style="display: inline-block;"> <i class="bx bx-edit"></i></a>
                                            <form action="/kelolabiller/{{ $billers->id }}" method="post"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </form>
                                        </td>
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
                    "emptyTable": "Tidak ada data biller"
                },
            });
        });
    </script>
@endsection
