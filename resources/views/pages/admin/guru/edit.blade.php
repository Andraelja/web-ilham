@extends('layouts.main')

@section('title', 'Edit Guru')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        @foreach ($errors->all() as $error )
                        {{ $error }}
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Guru {{ $guru->nama }}</h4>
                        <a href="{{ route('guru.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('guru.update', $guru->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <img src="{{ url(Storage::url($guru->foto)) }}" style="width: 120px" alt="foto guru">
                            <div class="form-group">
                                <label for="foto">Foto Guru</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="foto" type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto">
                                        <label class="custom-file-label" for="foto">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Guru</label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama Guru') }}" value="{{ $guru->nama }}">
                            </div>
                            <div class="d-flex">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="{{ __('NIP Guru') }}" value="{{ $guru->nip }}">
                                </div>
                                <div class="form-group ml-4">
                                    <label for="no_telp">No. Telp</label>
                                    <input type="text" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" placeholder="{{ __('No. TElp Guru') }}" value="{{ $guru->no_telp }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Textarea</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}">{{ $guru->alamat }}</textarea>
                            </div>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
