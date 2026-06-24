@extends('backend.v_layouts.app')

@section('content')
<div class="page-header">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">User</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ul>
    <h1 class="page-title">{{ $judul }}</h1>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-header-title">
            <i class="ri-user-settings-line" style="color:var(--brand);"></i>
            Data Profil Pengguna
        </span>
    </div>
    <div class="card-body">
        <form action="{{ route('backend.user.update', $edit->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="grid-2">
                <!-- Left: Foto -->
                <div style="padding-right: 20px;">
                    <div class="form-group">
                        <label class="form-label">Foto Profil</label>
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="width: 100%; aspect-ratio: 1/1; max-width: 320px; border-radius: var(--r-xl); overflow: hidden; background: var(--surface-2); border: 1px solid var(--border-lt); display: flex; align-items: center; justify-content: center;">
                                @if ($edit->foto)
                                    <img src="{{ asset('storage/img-user/' . $edit->foto) }}" id="fotoPreview" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($edit->nama) }}&background=f0e9e4&color=7a6254&size=256" id="fotoPreview" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div style="margin-top: 16px; max-width: 320px;">
                                <input type="file" name="foto" id="fotoInput" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()" accept=".png, .jpg, .jpeg, .webp">
                                <small style="display:block; margin-top:8px; color:var(--ink-4); font-size:0.75rem; line-height:1.4;">
                                    <i class="ri-information-line"></i> Gunakan foto format JPG/PNG, ukuran maksimal 1MB.
                                </small>
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Information -->
                <div>
                    <div class="grid-2" style="gap: 15px; margin-bottom: 20px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Hak Akses</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="1" {{ old('role', $edit->role) == '1' ? 'selected' : '' }}>Super Admin</option>
                                <option value="0" {{ old('role', $edit->role) == '0' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Status Akun</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $edit->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status', $edit->status) == '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $edit->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Siti Aisyah">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $edit->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@nyonyacrumb.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp / HP</label>
                        <input type="text" name="hp" value="{{ old('hp', $edit->hp) }}" class="form-control @error('hp') is-invalid @enderror" onkeypress="return hanyaAngka(event)" placeholder="08xxxxxxxxxx">
                        @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-top: 40px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid var(--border-lt); padding-top: 24px;">
                        <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">
                            <i class="ri-close-line"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFoto() {
        const input = document.getElementById('fotoInput');
        const preview = document.getElementById('fotoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
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