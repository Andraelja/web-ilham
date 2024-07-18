<!DOCTYPE html>
<html>
<head>
    <title>Cetak Report</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: sans-serif;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            background-color: blue;
            color: #fff;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="file"] {
            display: none;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            border-radius: 3px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
        }

        .link-download {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
    @if(count($rapors) > 0)
        <span>[ {{ $rapors[0]->nama }} ]</span>
    @else
        <p>No reports available.</p>
    @endif
</div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if (session('file_path'))
                    <div class="link-download">
                        <a href="{{ asset('storage/' . session('file_path')) }}" download>Download Rapor</a>
                    </div>
                @endif
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form id="uploadForm" action="{{ route('rapor.uploadPdf') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="tahun_ajaran">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran">
                    <option value="2023/2024">2023/2024</option>
                    <!-- Tambahkan pilihan tahun ajaran lain sesuai kebutuhan -->
                </select>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <select name="semester" id="semester">
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                    <!-- Tambahkan pilihan semester lain sesuai kebutuhan -->
                </select>
            </div>
            <div class="form-group">
                <label for="rapor_pdf">Pilih File PDF</label>
                <input type="file" name="rapor_pdf" id="rapor_pdf" onchange="document.getElementById('uploadForm').submit();">
            </div>
        </form>

        <button type="button" onclick="document.getElementById('rapor_pdf').click();">Choose File</button>

        @if(count($rapors) > 0)
            <a href="{{ route('rapor.generatePdf', $rapors[0]->id) }}"><button type="button">Download Rapor</button></a>
        @endif
    </div>
    <script>
        document.getElementById('rapor_pdf').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
</body>
</html>
