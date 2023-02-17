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
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Peserta</th>
                            <th scope="col">Angkatan</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @foreach ($training->participants as $participant)
                            <?php $no++; ?>
                            <tr>
                                <th scope="row" class="text-center">{{ $no }}</th>
                                <td>{{ $participant->name }}</td>
                                <td class="text-center">{{ $training->batch }}</td>
                                <td class="text-center">
                                    <a href="{{ route('show.participant', $participant->slug) }}" class="btn btn-warning">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
