@extends('layouts.main')

@section('title', 'Edit Siswa - Schoularium')

@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Siswa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('daftar-siswa.index') }}">Data Siswa</a></li>
                    <li class="breadcrumb-item active">Edit Siswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('daftar-siswa.update', $siswa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        value="{{ $siswa->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nipd">NIPD</label>
                                    <input type="text" name="nipd" class="form-control" id="nipd"
                                        value="{{ $siswa->nipd }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="Laki-laki"
                                            {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input type="text" name="nisn" class="form-control" id="nisn"
                                        value="{{ $siswa->nisn }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        @foreach ($kelas as $kls)
                                            <option value="{{ $kls->id }}">{{ $kls->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

@endsection

@section('scripts')
@endsection
