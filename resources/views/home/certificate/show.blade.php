@extends('home.layouts.app')

@section('title', 'Peserta', $certificate->participant->name)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Certificate</a></li>
                <li class="breadcrumb-item text-uppercase"><a
                        href="{{ route('show.category', $certificate->training->category->title) }}">{{ $certificate->training->category->title }}</a>
                </li>
                <li class="breadcrumb-item text-capitalize"><a
                        href="{{ route('show.training', $certificate->training->slug) }}">{{ $certificate->training->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $certificate->name }}</li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">

            <div class="col-lg-12">
                <div class="text-center">
                    {{-- <h3>Tahun {{ $training->year }}</h3> --}}
                    <a href="{{ route('show.training', $certificate->training->slug) }}" class="btn btn-outline-dark">
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
                                    <td>{{ $certificate->participant->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIK</th>
                                    <td>{{ $certificate->participant->nik }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIP</th>
                                    <td>
                                        @if ($certificate->participant->nip == 0)
                                            -
                                        @else
                                            {{ $certificate->participant->nip }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Pelatihan</th>
                                    <td>{{ $certificate->training->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tahun</th>
                                    <td>{{ $certificate->training->year }}</td>
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
            <div class="col-lg-12 py-4">
                <div class="card">
                    <div class="card-body">
                        <iframe
                            src="{{ asset('certificates/' . $certificate->training->category->title . '/' . $certificate->code . '.pdf') }}"
                            frameBorder="0" scrolling="auto" height="900px" width="100%"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
