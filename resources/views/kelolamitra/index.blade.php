@extends('kelolamitra.layout')

@section('title')
    Kelola Data Mitra
@endsection

<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Kelola Data Mitra</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
                <li class="breadcrumb-item active">Kelola Data Mitra</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Data Mitra</h5>
                        <p><a href="/kelolamitra/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah
                                    Data Mitra
                                </button></a> </p>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th width="5%"> No</th>
                                    <th>Nama</th>
                                    <th>Kode Mitra</th>
                                    <th>Bank</th>
                                    <th>File Template</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mitra as $mitras)
                                    <tr>
                                        <td class="text-center"> <?php echo $no++; ?> </td>
                                        <td> {{ $mitras->nama_cid }} </td>
                                        <td> {{ $mitras->kode_cid }}</td>
                                        <td> {{ @$mitras->Bank->nama_bank }}</td>
                                        <td> @if(!empty($mitras->filetemplate)) <a href="{{asset('/excelTemplate/'.$mitras->filetemplate )}}">{{ $mitras->filetemplate }} @else - @endif</a></td>
                                        
                                        <td class="text-center">
                                            <a href="/kelolamitra/{{ $mitras->id }}/edit/" class="btn btn-warning"
                                                style="display: inline-block;"> <i class="bx bx-edit"></i></a>
                                            <form action="/kelolamitra/{{ $mitras->id }}" method="post"
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
