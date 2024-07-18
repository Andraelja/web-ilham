@extends('layouts.main')

@section('title', 'Data Siswa - Schoularium')

@section('content')

    <main id="main" class="main">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="pagetitle">
            <h1>Data Siswa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Siswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{ route('daftar-siswa.create') }}" class="btn btn-primary" role="button">Tambah
                                Siswa</a>
                        </div>
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIPD</th>
                                        <th>Jenis Kelamin</th>
                                        <th>NISN</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->nipd }}</td>
                                            <td>{{ $item->jenis_kelamin }}</td>
                                            <td>{{ $item->nisn }}</td>
                                            <td>
                                                <a href="{{ route('daftar-siswa.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="bi bi-pencil"> Edit</i></a>
                                                <form action="{{ route('daftar-siswa.destroy', $item->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="bi bi-trash">Hapus</i></button>
                                                </form>
                                                <a href="{{ route('rapor.index', $item->id) }}" class="btn btn-sm btn-primary">Upload Rapor</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

@endsection

@section('scripts')
@endsection
