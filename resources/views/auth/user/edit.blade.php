@extends('auth.layouts.app')

@section('title', 'Buat Pengguna Baru')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Pengguna</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.user.index') }}">
                            <i class="fas fa-users-cog"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.user.edit', $user->slug) }}">Edit</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-lg-12 py-3 mb-4">
                    <a href="{{ route('dashboard.user.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.user.update', $user->slug) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Lengkap"
                                        required value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Username"
                                        required value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-icon">
                                        <input type="password" id="inputPassword" class="form-control" name="password"
                                            placeholder="New Password">
                                        <span class="input-icon-addon" onclick="showPassword()" style="cursor: pointer;">
                                            <i class="icon-eye"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password Confirmation</label>
                                    <div class="input-icon">
                                        <input type="password" id="inputPasswordConfirmation" class="form-control"
                                            name="password_confirmation">
                                        <span class="input-icon-addon" onclick="showPasswordConfirmation()"
                                            style="cursor: pointer;">
                                            <i class="icon-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Role</label>
                                    <select class="form-control input-square" name="role" id="squareSelect">
                                        <option value="">-select roles-</option>
                                        <option value="admin" @if (old('role', $user->role) == 'admin') {{ 'selected' }} @endif>
                                            Admin</option>
                                        <option value="editor" @if (old('role', $user->role) == 'editor') {{ 'selected' }} @endif>
                                            Editor</option>
                                        <option value="viwer" @if (old('role', $user->role) == 'viwer') {{ 'selected' }} @endif>
                                            Viwer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success btn-round float-right">
                                        <i class="fas fa-sync"></i>
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        function showPassword() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function showPasswordConfirmation() {
            var x = document.getElementById("inputPasswordConfirmation");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endpush
