@extends('home.layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Certificate</li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center">
            <h3 class="text-center py-4">Pelatihan</h3>
            @foreach ($categories as $category)
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h4 class="text-uppercase">{{ $category->title }}</h4>
                            <a href="{{ route('show.category', $category->slug) }}"
                                class="btn btn-outline-success btn-sm">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
