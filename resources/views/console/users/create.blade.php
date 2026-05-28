@extends('console.layouts.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Tambah Pengguna</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('console.users.index') }}" class="text-muted text-hover-primary">Pengguna</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Tambah</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card">
            <div class="card-body py-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('console.users.store') }}" method="POST" class="form">
                    @csrf
                    
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control mb-2" value="{{ old('name') }}" required />
                    </div>
                    
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Email</label>
                        <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}" required />
                    </div>
                    
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Password</label>
                        <input type="password" name="password" class="form-control mb-2" required minlength="8" />
                        <div class="text-muted fs-7">Minimal 8 karakter.</div>
                    </div>
                    
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control mb-2" required minlength="8" />
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('console.users.index') }}" class="btn btn-light me-5">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
