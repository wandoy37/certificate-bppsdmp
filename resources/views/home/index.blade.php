@extends('home.layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">
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
