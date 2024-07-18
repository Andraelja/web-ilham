@extends('layouts.main')
@section('title', 'Tambah Kelas')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Kelas</h1>
    </div>

    <div class="section-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Kelas</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kelas.storeKelas') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_kelas">Nama Kelas</label>
                                <input type="text" class="form-control" id="nama_kelas" name="kelas" value="{{ old('nama_kelas') }}" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
