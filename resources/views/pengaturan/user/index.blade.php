@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex ">
                                <h3 class="card-title d-flex align-items-center">Table Data User</h3>
                                <a href="{{route('pengaturan.user.create')}}" class="btn btn-primary ml-auto">Tambah Data</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Tanggal Buat</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>
                                                    @foreach ($item->roles as $role)
                                                        {{$role->name}}{{$item->roles->count() != $loop->iteration ? ', ' : ''}}
                                                    @endforeach
                                                </td>
                                                <td>{{$item->created_at}}</td>
                                                <td class="text-center">
                                                  @if ($item->email != 'admin@admin.com')
                                                    <a href="{{ route('pengaturan.user.edit', $item->id) }}" class="btn btn-light-warning btn-sm btn-icon" title="Edit Pengaduan">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <button type="button" onclick="return deletePengaduan('{{$item->id}}')" class="btn btn-light-danger btn-sm btn-icon" title="Hapus Pengaduan">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <form id="form-delete-{{$item->id}}" action="{{ route('pengaturan.user.destroy', $item->id) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                  @endif
                                                </td>                                                    
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });     
        });
    </script>
    <script text="javascript">
        function deletePengaduan(token) {
            Swal.fire({
                title: "Yakin akan dihapus?",
                text: "Setelah dihapus data tidak akan tampil di aplikasi.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then(function(result) {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('form-delete-' + token).submit();
                }
            });
        }
    </script>    
@endpush
