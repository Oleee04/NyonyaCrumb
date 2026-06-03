@extends('v_layouts.app')

@section('content')
<style>
    .profile-section {
        padding: 160px 0 100px;
        min-height: 80vh;
        background: var(--bg-creme);
    }

    .profile-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 50px;
        max-width: 900px;
        margin: 0 auto;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
    }

    .section-title-nc {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 30px;
        text-align: center;
        border-bottom: 1px solid var(--border);
        padding-bottom: 15px;
    }

    .form-group-nc {
        margin-bottom: 25px;
    }

    .form-group-nc label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
        display: block;
    }

    .form-control-nc {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid var(--border);
        background: var(--bg-creme);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--text-dark);
        transition: 0.3s;
    }

    .form-control-nc:focus {
        outline: none;
        border-color: var(--text-dark);
        background: var(--bg-white);
        box-shadow: 0 0 0 2px rgba(62, 39, 35, 0.05);
    }

    .foto-preview-wrapper {
        text-align: center;
        margin-bottom: 30px;
    }

    .foto-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--bg-creme);
        box-shadow: var(--shadow-md);
        margin-bottom: 15px;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .btn-upload-nc {
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-dark);
        padding: 8px 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        border-radius: 30px;
    }

    .btn-upload-nc:hover {
        background: var(--bg-creme);
        border-color: var(--primary);
    }

    .file-upload-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }

    .btn-save-nc {
        background: var(--text-dark);
        color: white;
        border: none;
        padding: 16px 40px;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        border-radius: var(--radius-sm);
        margin-top: 20px;
    }

    .btn-save-nc:hover {
        background: var(--primary);
    }

    .alert-custom {
        border-radius: var(--radius-sm);
        border: none;
        font-size: 14px;
        padding: 15px 20px;
    }

    .alert-success-nc {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .alert-danger-nc {
        background: #FFEBEE;
        color: #C62828;
    }

    @media (max-width: 768px) {
        .profile-card { padding: 30px 20px; }
    }
</style>

<div class="profile-section">
    <div class="container">
        <div class="profile-card reveal">

            {{-- Tombol Kembali --}}
            <div style="margin-bottom: 20px;">
                <a href="{{ route('beranda') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: 600; color: var(--text-muted); text-decoration: none; transition: 0.3s;">
                    <i class="fa fa-arrow-left" style="font-size: 10px;"></i> Kembali
                </a>
            </div>

            <h1 class="section-title-nc">{{ $judul ?? 'Profil Saya' }}</h1>

            @if(session()->has('success'))
                <div class="alert alert-custom alert-success-nc mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session()->has('msgError'))
                <div class="alert alert-custom alert-danger-nc mb-4">
                    {{ session('msgError') }}
                </div>
            @endif

            <form action="{{ route('customer.akun.update', $edit->user->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="row">
                    <!-- Kolom Foto -->
                    <div class="col-md-4">
                        <div class="foto-preview-wrapper">
                            @if ($edit->user->foto)
                                <img src="{{ asset('storage/img-customer/' . $edit->user->foto) }}" class="foto-preview" id="preview-image">
                            @else
                                <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview" id="preview-image">
                            @endif
                            
                            <div class="file-upload-wrapper mt-3">
                                <button type="button" class="btn-upload-nc"><i class="fa fa-camera"></i> Ubah Foto</button>
                                <input type="file" name="foto" onchange="previewFoto(this)">
                            </div>
                            @error('foto')
                                <div class="text-danger mt-2" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Data Diri -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-nc">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $edit->user->nama) }}" class="form-control-nc @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap">
                                    @error('nama') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-nc">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $edit->user->email) }}" class="form-control-nc @error('email') is-invalid @enderror" placeholder="contoh@email.com">
                                    @error('email') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-nc">
                                    <label>Nomor Telepon</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="hp" value="{{ old('hp', $edit->user->hp) }}" class="form-control-nc @error('hp') is-invalid @enderror" placeholder="Contoh: 081234567890">
                                    @error('hp') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-nc">
                                    <label>Kode Pos</label>
                                    <input type="text" name="pos" value="{{ old('pos', $edit->pos) }}" class="form-control-nc @error('pos') is-invalid @enderror" placeholder="5 digit kode pos" maxlength="5">
                                    @error('pos') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group-nc">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control-nc @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap rumah Anda">{{ old('alamat', $edit->alamat) }}</textarea>
                            @error('alamat') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-save-nc">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection
