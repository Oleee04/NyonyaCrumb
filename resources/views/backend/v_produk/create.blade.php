@extends('backend.v_layouts.app')
@section('page_title', $judul)
@section('content')

<style>
    /* ─── Form Card ──────────────────────────────── */
    .produk-form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .produk-form-card:hover {
        box-shadow: var(--shadow-md);
        border-color: var(--accent-glow);
    }

    /* ─── Form Header ────────────────────────────── */
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, var(--surface-2) 0%, var(--surface) 100%);
    }

    .form-section-header .header-icon {
        width: 38px;
        height: 38px;
        background: var(--accent-light);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .form-section-header .header-text h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--ink);
        margin: 0;
        line-height: 1.2;
    }

    .form-section-header .header-text p {
        font-size: 0.73rem;
        color: var(--ink-3);
        margin: 2px 0 0;
        font-weight: 500;
    }

    /* ─── Upload Zone ────────────────────────────── */
    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
        background: var(--surface-2);
        transition: all 0.2s ease;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        min-height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: var(--accent);
        background: var(--accent-light);
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 24px;
        pointer-events: none;
        z-index: 1;
        transition: all 0.2s ease;
    }

    .upload-placeholder i {
        font-size: 2.2rem;
        color: var(--ink-4);
    }

    .upload-placeholder .upload-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--ink-2);
    }

    .upload-placeholder .upload-sub {
        font-size: 0.72rem;
        color: var(--ink-4);
        font-weight: 500;
    }

    .upload-zone.has-preview .upload-placeholder {
        display: none;
    }

    .foto-preview {
        width: 100%;
        height: 100%;
        max-height: 280px;
        object-fit: cover;
        display: none;
        position: relative;
        z-index: 1;
        border-radius: var(--radius-md);
    }

    .upload-zone.has-preview .foto-preview {
        display: block;
    }

    .foto-change-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 3;
        border-radius: var(--radius-md);
        pointer-events: none;
    }

    .upload-zone.has-preview:hover .foto-change-overlay {
        opacity: 1;
    }

    .foto-change-overlay span {
        color: #fff;
        font-size: 0.80rem;
        font-weight: 700;
        background: var(--accent);
        padding: 6px 14px;
        border-radius: 20px;
    }

    /* ─── Field Groups ───────────────────────────── */
    .form-body {
        padding: 24px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 576px) {
        .field-row { grid-template-columns: 1fr; }
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 18px;
    }

    .field-group label {
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        color: var(--ink-2) !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0 !important;
    }

    .field-group .form-control,
    .field-group .form-select {
        background: var(--surface-2) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-md) !important;
        color: var(--ink) !important;
        font-size: 0.85rem !important;
        padding: 10px 14px !important;
        transition: all 0.15s ease;
    }

    .field-group .form-control:focus,
    .field-group .form-select:focus {
        background: var(--surface) !important;
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px var(--accent-glow) !important;
    }

    .field-group .form-control.is-invalid {
        border-color: var(--rose) !important;
    }

    .field-group .invalid-feedback {
        font-size: 0.72rem;
        color: var(--rose);
        font-weight: 600;
        margin-top: 4px;
    }

    /* Input dengan prefix rupiah */
    .input-prefix-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-prefix {
        position: absolute;
        left: 12px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--ink-3);
        pointer-events: none;
        z-index: 2;
    }

    .input-prefix-wrap .form-control {
        padding-left: 42px !important;
    }

    .input-suffix-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-suffix {
        position: absolute;
        right: 12px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--ink-4);
        pointer-events: none;
        z-index: 2;
    }

    .input-suffix-wrap .form-control {
        padding-right: 44px !important;
    }

    /* ─── Divider ────────────────────────────────── */
    .form-section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 8px 0 20px;
    }

    .form-section-divider span {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--ink-4);
        white-space: nowrap;
    }

    .form-section-divider::before,
    .form-section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ─── Action Bar ─────────────────────────────── */
    .form-action-bar {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-save {
        background: var(--accent) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 24px !important;
        border-radius: var(--radius-md) !important;
        font-size: 0.83rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 2px 10px var(--accent-glow) !important;
        transition: all 0.15s ease;
    }

    .btn-save:hover {
        background: #5e4530 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px var(--accent-glow) !important;
    }

    .btn-back {
        background: var(--surface) !important;
        color: var(--ink-2) !important;
        border: 1px solid var(--border) !important;
        padding: 10px 20px !important;
        border-radius: var(--radius-md) !important;
        font-size: 0.83rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-back:hover {
        background: var(--surface-2) !important;
        transform: translateY(-1px);
        color: var(--ink) !important;
    }

    /* ─── Layout Grid ────────────────────────────── */
    .produk-form-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 0;
    }

    .form-left-col {
        border-right: 1px solid var(--border);
        padding: 24px;
        background: var(--surface-2);
    }

    .form-right-col {
        padding: 24px;
    }

    @media (max-width: 768px) {
        .produk-form-layout {
            grid-template-columns: 1fr;
        }
        .form-left-col {
            border-right: none;
            border-bottom: 1px solid var(--border);
        }
    }

    /* ─── CKEditor Override ──────────────────────── */
    .ck-editor__editable {
        min-height: 130px !important;
        font-size: 0.84rem !important;
        border-bottom-left-radius: var(--radius-md) !important;
        border-bottom-right-radius: var(--radius-md) !important;
    }

    .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
        border-color: var(--border) !important;
    }

    .ck.ck-editor__main > .ck-editor__editable.ck-focused {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px var(--accent-glow) !important;
    }

    .ck.ck-toolbar {
        border-top-left-radius: var(--radius-md) !important;
        border-top-right-radius: var(--radius-md) !important;
        background: var(--surface-2) !important;
        border-color: var(--border) !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="produk-form-card">
            <form class="form-horizontal" action="{{ route('backend.produk.store') }}" method="post"
                  enctype="multipart/form-data">
                @csrf

                {{-- Header --}}
                <div class="form-section-header">
                    <div class="header-icon">
                        <i class="ri-add-circle-line"></i>
                    </div>
                    <div class="header-text">
                        <h5>{{ $judul }}</h5>
                        <p>Lengkapi semua informasi produk di bawah ini</p>
                    </div>
                </div>

                {{-- Body: 2-column layout --}}
                <div class="produk-form-layout">

                    {{-- LEFT: Foto --}}
                    <div class="form-left-col">
                        <div class="field-group">
                            <label><i class="ri-image-line" style="margin-right:4px;"></i>Foto Produk</label>
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="foto" id="fotoInput"
                                       accept="image/*"
                                       class="@error('foto') is-invalid @enderror"
                                       onchange="previewFoto()">
                                <img class="foto-preview" id="fotoPreview" alt="Preview Foto Produk">
                                <div class="foto-change-overlay"><span><i class="ri-camera-line"></i> Ganti Foto</span></div>
                                <div class="upload-placeholder">
                                    <i class="ri-image-add-line"></i>
                                    <div class="upload-title">Upload Foto Produk</div>
                                    <div class="upload-sub">Klik atau seret file ke sini<br>JPG, PNG, WEBP — maks. 2MB</div>
                                </div>
                            </div>
                            @error('foto')
                                <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                    <i class="ri-error-warning-line"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tips --}}
                        <div style="margin-top:16px;padding:12px 14px;background:var(--accent-light);border-radius:var(--radius-md);border:1px solid var(--accent-glow);">
                            <div style="font-size:0.73rem;font-weight:700;color:var(--accent);margin-bottom:6px;">
                                <i class="ri-lightbulb-line"></i> Tips Foto
                            </div>
                            <ul style="margin:0;padding-left:16px;font-size:0.71rem;color:var(--ink-3);line-height:1.7;">
                                <li>Gunakan rasio 1:1 (kotak)</li>
                                <li>Resolusi minimal 500×500px</li>
                                <li>Latar belakang putih / terang</li>
                            </ul>
                        </div>
                    </div>

                    {{-- RIGHT: Data Produk --}}
                    <div class="form-right-col">

                        <div class="form-section-divider"><span>Informasi Dasar</span></div>

                        {{-- Kategori --}}
                        <div class="field-group">
                            <label><i class="ri-price-tag-3-line" style="margin-right:4px;"></i>Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                <option value="" selected>— Pilih Kategori —</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                    <i class="ri-error-warning-line"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama Produk --}}
                        <div class="field-group">
                            <label><i class="ri-cake-2-line" style="margin-right:4px;"></i>Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                                   class="form-control @error('nama_produk') is-invalid @enderror"
                                   placeholder="Contoh: Matcha Latte Cookie">
                            @error('nama_produk')
                                <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                    <i class="ri-error-warning-line"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Detail --}}
                        <div class="field-group">
                            <label><i class="ri-file-text-line" style="margin-right:4px;"></i>Deskripsi / Detail</label>
                            <textarea name="detail"
                                      class="form-control @error('detail') is-invalid @enderror"
                                      id="ckeditor"
                                      rows="4"
                                      placeholder="Deskripsikan produk ini…">{{ old('detail') }}</textarea>
                            @error('detail')
                                <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                    <i class="ri-error-warning-line"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-section-divider"><span>Harga & Stok</span></div>

                        <div class="field-row">
                            {{-- Harga --}}
                            <div class="field-group">
                                <label><i class="ri-money-dollar-circle-line" style="margin-right:4px;"></i>Harga (Rp)</label>
                                <div class="input-prefix-wrap">
                                    <span class="input-prefix">Rp</span>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="harga"
                                           value="{{ old('harga') }}"
                                           class="form-control @error('harga') is-invalid @enderror"
                                           placeholder="0">
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                        <i class="ri-error-warning-line"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Berat --}}
                            <div class="field-group">
                                <label><i class="ri-scales-3-line" style="margin-right:4px;"></i>Berat</label>
                                <div class="input-suffix-wrap">
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="berat"
                                           value="{{ old('berat') }}"
                                           class="form-control @error('berat') is-invalid @enderror"
                                           placeholder="0">
                                    <span class="input-suffix">gram</span>
                                </div>
                                @error('berat')
                                    <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                        <i class="ri-error-warning-line"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Stok --}}
                        <div class="field-group">
                            <label><i class="ri-stack-line" style="margin-right:4px;"></i>Stok</label>
                            <div class="input-suffix-wrap">
                                <input type="text" onkeypress="return hanyaAngka(event)" name="stok"
                                       value="{{ old('stok') }}"
                                       class="form-control @error('stok') is-invalid @enderror"
                                       placeholder="0" style="max-width:200px;">
                                <span class="input-suffix">pcs</span>
                            </div>
                            @error('stok')
                                <div class="invalid-feedback d-block" style="font-size:0.72rem;color:var(--rose);font-weight:600;margin-top:4px;">
                                    <i class="ri-error-warning-line"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>{{-- /form-right-col --}}
                </div>{{-- /produk-form-layout --}}

                {{-- Action Bar --}}
                <div class="form-action-bar">
                    <a href="{{ route('backend.produk.index') }}" class="btn-back">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="ri-save-3-line"></i> Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    /* Preview foto dengan toggle class */
    window.previewFoto = function () {
        const input   = document.getElementById('fotoInput');
        const preview = document.getElementById('fotoPreview');
        const zone    = document.getElementById('uploadZone');

        if (input && input.files[0] && preview) {
            const reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = (e) => {
                preview.src = e.target.result;
                zone.classList.add('has-preview');
            };
        }
    };

    /* Drag & Drop visual feedback */
    const zone = document.getElementById('uploadZone');
    if (zone) {
        zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('dragover'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
        zone.addEventListener('drop', () => zone.classList.remove('dragover'));
    }

    /* Hanya angka */
    window.hanyaAngka = function (e) {
        return /[0-9]/.test(String.fromCharCode(e.which));
    };
</script>
@endsection