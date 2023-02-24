@extends('home.layouts.app')

@section('title', 'Peserta', $participant->name)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Certificate</a></li>
                <li class="breadcrumb-item text-uppercase"><a
                        href="{{ route('show.category', $participant->training->category->title) }}">{{ $participant->training->category->title }}</a>
                </li>
                <li class="breadcrumb-item text-capitalize"><a
                        href="{{ route('show.training', $participant->training->slug) }}">{{ $participant->training->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $participant->name }}</li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">

            <div class="col-lg-12">
                <div class="text-center">
                    {{-- <h3>Tahun {{ $training->year }}</h3> --}}
                    <a href="{{ route('show.training', $participant->training->slug) }}" class="btn btn-outline-dark">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                    <div class="my-4">
                        <h3>Informasi Peserta</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td>{{ $participant->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIK</th>
                                    <td>{{ $participant->nik }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIP</th>
                                    <td>
                                        @if ($participant->nip == 0)
                                            -
                                        @else
                                            {{ $participant->nip }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Pelatihan</th>
                                    <td>{{ $participant->training->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Angkatan</th>
                                    <td>{{ $participant->training->batch }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tahun</th>
                                    <td>{{ $participant->training->year }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td class="text-success fw-bold text-uppercase">Telah Mengikuti Pelatihan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-12 py-4">
                <div class="card">
                    <div class="card-body">
                        <iframe src="{{ asset('certificates/' . $participant->document) }}" frameBorder="0"
                            scrolling="auto" height="900px" width="100%"></iframe>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
