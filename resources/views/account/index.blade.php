@extends('account.layout')

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
                    <p><a href="/account/create"> <button id="addRow" type="submit" class="btn btn-primary ">Tambah Data
                                Akun
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
                            @foreach ($account as $accounts)
                            <tr>
                                <td class="text-center"> <?php echo $no++; ?> </td>
                                <td> {{ $accounts->name }} </td>
                                <td> {{ $accounts->email }}</td>
                                <td> {{ $accounts->role }}</td>
                                <td>{!! $accounts->is_aktif == 0 ? "<label class='text-danger'>Not Active</label>" : "<label class='text-success'>Active</label>" !!}</td>
                                <td class="text-center">
                                    @if($accounts->is_forget_password == 1)
                                    <a href="javascript:void(0)" class="btn btn-success btnResetPassword" data-id="{{$accounts->id}}" style="display: inline-block;"> <i class="bx bx-refresh"></i></a>

                                    @endif
                                    @if(Auth::User()->id != $accounts->id)
                                    <form action="/account/{{ $accounts->id }}" method="post" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"> <i class="bx bxs-trash"></i></button>
                                    </form>
                                    @endif
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

<!-- Basic Modal -->
<div class="modal fade" id="modalReset" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formReset">
                @csrf
                @method('PATCH')
            <div class="modal-body">
               Dengan ini, Password Akun akan direset menjadi Password Deault, Lanjutkan?
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
                "emptyTable": "Tidak ada akun account"
            },
        });
    });

    $(document).on('click', '.btnResetPassword', function() {
        $('#formReset').prop('action','/account/'+$(this).attr('data-id')+'/resetPassword');
        $('#modalReset').modal('show');
    });

    $('#modalReset').on('hidden.bs.modal',function(){
        $('#formReset').removeAttr('action');
    })
</script>
@endsection