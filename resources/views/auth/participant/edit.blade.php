@extends('auth.layouts.app')

@section('title', 'Edit Peserta')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Peserta</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.participant.index') }}">
                            {{-- <i class="flaticon-home"></i> --}}
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.participant.edit', $participant->slug) }}">Edit</a>
                    </li>
                    {{-- <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Starter Page</a>
                    </li> --}}
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            <div class="row">
                <div class="col-lg-12 py-3 mb-4">
                    <a href="{{ route('dashboard.participant.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.participant.update', $participant->slug) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Peserta</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Nama Peserta ..." required
                                                value="{{ old('name', $participant->name) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input type="number" class="form-control" name="nip" placeholder="NIP ..."
                                                required value="{{ old('nip', $participant->nip) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="number" class="form-control" name="nik" placeholder="NIK ..."
                                                required value="{{ old('nik', $participant->nik) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Pangkat/Golongan</label>
                                            <input type="text" class="form-control" name="pangkat_golongan"
                                                placeholder="Pangkat/Golongan ..." required
                                                value="{{ old('pangkat_golongan', $participant->pangkat_golongan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan"
                                                placeholder="Jabatan ..." required
                                                value="{{ old('jabatan', $participant->jabatan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Instansi</label>
                                            <input type="text" class="form-control" name="instansi"
                                                placeholder="Instansi ..." required
                                                value="{{ old('instansi', $participant->instansi) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                placeholder="Email ..." required
                                                value="{{ old('email', $participant->email) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" class="form-control text-capitalize">
                                                <option value="">-select role-</option>
                                                @foreach ($roles as $role)
                                                    @if (old($role->id, $participant->role_id) == $role->id)
                                                        <option value="{{ $role->id }}" selected>{{ $role->title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pelatihan yang diikuti</label>
                                            <select name="training" class="form-control text-capitalize">
                                                <option value="">-select pelatihan-</option>
                                                @foreach ($trainings as $training)
                                                    @if (old($training->id, $participant->training_id) == $training->id)
                                                        <option value="{{ $training->id }}" selected>
                                                            {{ $training->title . ' angkatan ' . $training->batch . ' tahun ' . $training->year }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $training->id }}">
                                                            {{ $training->title . ' angkatan ' . $training->batch . ' tahun ' . $training->year }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Document Certificate</label>
                                            <br>
                                            <iframe src="{{ asset('certificates/' . $participant->document) }}"
                                                frameBorder="0" scrolling="auto" height="180px" width="650px"></iframe>
                                            <input type="file" class="form-control" name="document">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-success btn-round float-right">
                                                <i class="fas fa-sync"></i>
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
