@extends('backend.v_layouts.app')

@section('content')
<style>
    .electre-page {
        padding: 32px 24px;
        background: linear-gradient(135deg, #fdfbfb 0%, #f4f5f7 100%);
        min-height: calc(100vh - 80px);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .electre-header {
        margin-bottom: 36px;
        text-align: center;
    }

    .electre-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: #3b2f2f;
        margin: 0;
        letter-spacing: -0.5px;
        background: linear-gradient(to right, #7a6254, #b29079);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .electre-header p {
        margin: 12px 0 0;
        color: #6b7280;
        font-size: 16px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .upload-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        padding: 40px;
        max-width: 640px;
        margin: 0 auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0,0,0,0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .upload-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px rgba(122, 98, 84, 0.08), 0 2px 6px rgba(0,0,0,0.03);
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 12px;
        margin: 0 auto 24px auto;
        max-width: 640px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        background: rgba(248, 250, 252, 0.6);
        padding: 48px 32px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .upload-area:hover, .upload-area:focus-within {
        border-color: #7a6254;
        background: rgba(122, 98, 84, 0.02);
    }

    .upload-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f3edea 0%, #e8dbd2 100%);
        color: #7a6254;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        box-shadow: 0 8px 16px rgba(122, 98, 84, 0.12);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .upload-area:hover .upload-icon, .upload-area:focus-within .upload-icon {
        transform: scale(1.1) translateY(-4px);
        box-shadow: 0 12px 20px rgba(122, 98, 84, 0.18);
    }

    .upload-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .upload-desc {
        color: #6b7280;
        font-size: 15px;
        margin-bottom: 28px;
    }

    .file-input {
        width: 100%;
        max-width: 400px;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        font-size: 14px;
        color: #4b5563;
        transition: all 0.3s ease;
        margin: 0 auto 28px;
        display: block;
        cursor: pointer;
    }

    .file-input:focus, .file-input:hover {
        outline: none;
        border-color: #d6ccc6;
        box-shadow: 0 0 0 4px rgba(122, 98, 84, 0.08);
    }

    .file-input::file-selector-button {
        border: none;
        background: #f1f5f9;
        padding: 8px 18px;
        border-radius: 8px;
        color: #475569;
        cursor: pointer;
        font-weight: 600;
        margin-right: 16px;
        transition: all 0.2s ease;
    }

    .file-input::file-selector-button:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .btn-submit {
        border: none;
        background: linear-gradient(135deg, #7a6254 0%, #5d493e 100%);
        color: #ffffff;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(122, 98, 84, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        justify-content: center;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(122, 98, 84, 0.35);
        background: linear-gradient(135deg, #836b5c 0%, #685246 100%);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .format-note {
        margin-top: 32px;
        font-size: 14px;
        color: #4b5563;
        line-height: 1.8;
        text-align: center;
        padding-top: 24px;
        border-top: 1px solid rgba(229, 231, 235, 0.8);
    }

    .badge-container {
        margin-top: 12px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }

    .badge {
        display: inline-block;
        padding: 6px 14px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        color: #7a6254;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
    }
    
    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(122, 98, 84, 0.08);
        border-color: #d6ccc6;
    }
</style>

<div class="electre-page">

    <div class="electre-header">
        <h1>Analisis ELECTRE</h1>
        <p>Unggah file Excel yang berisi data alternatif yang sudah dilikertkan untuk memulai analisis sistem pendukung keputusan.</p>
    </div>

    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="upload-card">
        <form action="{{ route('backend.electre.hitung') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="upload-area">
                <div class="upload-icon">
                    <i class="fas fa-file-excel"></i>
                </div>

                <div class="upload-title">
                    Upload Data ELECTRE
                </div>

                <div class="upload-desc">
                    Pilih file Excel dengan format .xlsx, .xls, atau .csv
                </div>

                <input type="file" name="file_excel" accept=".xlsx,.xls,.csv" class="file-input" required>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-cloud-upload-alt"></i> Upload & Hitung
                </button>
            </div>
        </form>

        <div class="format-note">
            <div>Kolom Excel wajib (Baris Pertama):</div>
            <div class="badge-container">
                <span class="badge">Nama Produk</span>
                <span class="badge">Alternatif</span>
                <span class="badge">C1</span>
                <span class="badge">C2</span>
                <span class="badge">C3</span>
            </div>
        </div>
    </div>

</div>
@endsection