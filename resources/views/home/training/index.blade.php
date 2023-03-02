@extends('home.layouts.app')

@section('title', 'Peserta', $training->title)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Certificate</a></li>
                <li class="breadcrumb-item text-uppercase"><a
                        href="{{ route('show.category', $training->category->title) }}">{{ $training->category->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $training->title }}</li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">

            <div class="col-lg-12">
                <div class="text-center">
                    <h3>{{ $training->title }}</h3>
                    <h3>Tahun {{ $training->year }}</h3>
                    <a href="{{ route('show.category', $training->category->slug) }}" class="btn btn-outline-dark">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <h3 class="text-center py-4">List Peserta</h3>
            <div class="col-lg-8">
                <table class="table table-hover table-bordered">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Nama Peserta</th>
                            <th scope="col">Code Certificate</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @foreach ($certificates as $certificate)
                            <?php $no++; ?>
                            <tr class="text-center">
                                <th scope="row">{{ $no }}</th>
                                <td>{{ $certificate->participant->name }}</td>
                                <td class="text-center">{{ $certificate->code }}</td>
                                <td class="text-center">
                                    <a href="{{ route('show.certificate', $certificate->code) }}" class="btn btn-warning">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-4 d-flex justify-content-center">
                    {{ $certificates->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
