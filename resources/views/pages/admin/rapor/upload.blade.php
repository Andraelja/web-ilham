<!DOCTYPE html>
<html>
<head>
    <title>RAPOR</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<style>


body {
    background-color: #f8f9fa;
    font-family: 'Arial', sans-serif;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    color: #343a40;
    margin-bottom: 20px;
    text-align: center;
}

h3 {
    color: #343a40;
    margin-top: 40px;
}

.form-group label {
    color: #495057;
    font-weight: bold;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    border-radius: 5px;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

.btn-danger {
    border-radius: 5px;
}

.alert {
    border-radius: 5px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}

ul {
    padding-left: 20px;
}

ul li {
    margin-bottom: 10px;
}

ul li a {
    color: #007bff;
}

ul li a:hover {
    text-decoration: underline;
}

ul li form {
    display: inline;
}

ul li .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 3px;
}
</style>
<div class="container mt-4">
    <h2>RAPOR</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
        
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Pilih file:</label>
            <input type="file" class="form-control" id="file" name="file">
            @error('file')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="semester">Pilih Semester:</label>
            <select class="form-control" id="semester" name="semester">
                <option value="ganjil">Ganjil</option>
                <option value="genap">Genap</option>
            </select>
            @error('semester')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Unggah</button>
        @if ($message = Session::get('success'))
            <a href="/download/{{ Session::get('file') }}" class="btn btn-secondary ml-2">Download</a>
        @endif
    </form>

    <h3 class="mt-5">File yang sudah diunggah:</h3>
    <ul>
        @foreach ($files as $file)
            <li>
                <a href="uploads/{{ $file->file_name }}" target="_blank">{{ $file->file_name }} (Semester: {{ $file->semester }})</a>
                <form action="/delete/{{ $file->file_name }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>