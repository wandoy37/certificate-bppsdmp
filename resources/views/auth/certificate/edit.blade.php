@extends('auth.layouts.app')

@section('title', 'Edit Sertifikat')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Sertifikat</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.index') }}">
                            {{-- <i class="flaticon-home"></i> --}}
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.certificate.edit', $certificate->code) }}">Edit</a>
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
                    <a href="{{ route('dashboard.certificate.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.certificate.update', $certificate->code) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="code .."
                                        value="{{ old('code', $certificate->code) }}">
                                    @error('code')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Pilih Pelatihan</label>
                                    <div class="select2-input">
                                        <select id="selectPelatihan" name="training" class="form-control">
                                            <option value="">-select pelatihan--</option>
                                            @foreach ($trainings as $training)
                                                @if (old($training->id, $certificate->training_id) == $training->id)
                                                    <option value="{{ $training->id }}" selected>{{ $training->title }}
                                                        Tahun
                                                        {{ $training->year }}</option>
                                                @else
                                                    <option value="{{ $training->id }}">{{ $training->title }} Tahun
                                                        {{ $training->year }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('training')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Pilih Peserta</label>
                                    <div class="select2-input">
                                        <select id="selectPeserta" name="participant" class="form-control">
                                            <option value="">-select peserta--</option>
                                            @foreach ($participants as $participant)
                                                @if (old($participant->id, $certificate->participant_id) == $participant->id)
                                                    <option value="{{ $participant->id }}" selected>
                                                        {{ $participant->name }}</option>
                                                @else
                                                    <option value="{{ $participant->id }}">{{ $participant->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('participant')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tanggal Terbit</label>
                                            <input type="text" class="form-control" name="date"
                                                placeholder="Example, 0 month 2023"
                                                value="{{ old('date', $certificate->tanggal_terbit) }}">
                                            @error('date')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Penandatangan</label>
                                            <select name="penandatangan" class="form-control">
                                                <option value="">-select penandatangan-</option>
                                                @foreach ($penandatangans as $penandatangan)
                                                    @if (old($penandatangan->id, $certificate->penandatangan_id) == $penandatangan->id)
                                                        <option value="{{ $penandatangan->id }}" selected>
                                                            {{ $penandatangan->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $penandatangan->id }}">
                                                            {{ $penandatangan->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('penandatangan')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success btn-round float-right">
                                        <i class="fas fa-plus"></i>
                                        Added
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
        $('#selectPelatihan').select2({
            theme: "bootstrap"
        });

        $('#selectPeserta').select2({
            theme: "bootstrap"
        });

        $('#datepicker').datetimepicker({
            // format: 'MM/DD/YYYY',
            format: 'YYYY-MM-DD',
        });
    </script>
@endpush
