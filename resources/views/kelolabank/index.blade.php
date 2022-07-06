@extends('kelolabank.layout')

@section('title')
Kelola Data Bank
@endsection

<?php $no = 1; ?>
@section('content')
@include('sweetalert::alert')
<div class="pagetitle">
    <h1>Kelola Data Bank</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/transaksi">Home</a></li>
            <li class="breadcrumb-item active">Kelola Data Bank</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kelola Data Bank</h5>
                    <p><a href="/kelolabank/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah
                                Data Bank
                            </button></a> </p>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th width="5%"> No</th>
                                <th>Nama</th>
                                <th>Kode Bank</th>
                                <th>File Template</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bank as $banks)
                            <tr>
                                <td class="text-center"> <?php echo $no++; ?> </td>
                                <td> {{ $banks->nama_bank }} </td>
                                <td> {{ $banks->kode_bank }}</td>
                                <td> @if(!empty($banks->filetemplate)) <a href="{{asset('/excelTemplate/'.$banks->filetemplate )}}">{{ $banks->filetemplate }} @else - @endif</a></td>
                                <td class="text-center">
                                    <a href="/kelolabank/{{ $banks->id }}/edit/" class="btn btn-warning" style="display: inline-block;"> <i class="bx bx-edit"></i></a>
                                    <button class="btn btn-danger btnDelete" type="button" data-id="{{ $banks->id }}"> <i class="bx bxs-trash"></i></button>
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

<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formDelete">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Dengan ini, Bank yang dipilih akan dihapus, Lanjutkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End Basic Modal-->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "emptyTable": "Tidak ada data bank"
            },
        });
    });

    $(document).on('click', '.btnDelete', function() {
        $('#formDelete').prop('action', '/kelolabank/' + $(this).attr('data-id'));
        $('#modalDelete').modal('show');
    });

    $('#modalReset').on('hidden.bs.modal', function() {
        $('#formDelete').removeAttr('action');
    })
</script>
@endsection