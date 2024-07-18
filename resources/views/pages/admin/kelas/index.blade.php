@extends('layouts.main')
@section('title', 'List Kelas')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Kelas</h4>
                            <a href="{{ route('kelas.createKelas') }}" class="btn btn-primary">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Kelas
                            </a>
                        </div>
                        
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                 <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                        </button>
                                        {{ $message }}
                                    </div>
                                </div>
                                @else
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kelas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Kelas {{ $data->kelas }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('daftar-siswa.show', $data->id) }}" class="btn btn-primary btn-sm mx-3"><i class="nav-icon fas fa-edit"></i> &nbsp; Lihat Siswa</a>
                                                        <a href="{{ route('kelas.edit', $data->id) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                        <form method="POST" action="{{ route('kelas.destroyKelas', $data->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
  </section>
@endsection

@push('script')
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Yakin ingin menghapus data ini?`,
                text: "Data akan terhapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                form.submit();
                }
            });
        });
    </script>
@endpush
