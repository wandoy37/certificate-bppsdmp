@extends('auth.layouts.app')

@section('title', 'Create Pelatihan')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pelatihan</h4>
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
                        <a href="{{ route('dashboard.training.edit', $training->slug) }}">Edit</a>
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
                    <a href="{{ route('dashboard.training.index') }}" class="btn btn-outline-dark btn-round">
                        <i class="fas fa-undo"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.training.update', $training->slug) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" class="form-control" name="code" placeholder="Code ..."
                                                required value="{{ old('code', $training->code) }}">
                                            @error('code')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Pelatihan</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Nama Pelatihan ..." required
                                                value="{{ old('title', $training->title) }}">
                                            @error('title')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="text" class="form-control" name="year" id="year"
                                                placeholder="Tahun ..." required value="{{ old('year', $training->year) }}">
                                            @error('year')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Durasi Pelatihan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="hour"
                                                    placeholder="Durasi Pelatihan ..."
                                                    value="{{ old('hour', $training->hour) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Jam</span>
                                                </div>
                                            </div>
                                            @error('hour')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Pelaksanaan</label>
                                            <input type="text" class="form-control" name="tanggal_pelaksanaan"
                                                value="{{ old('tanggal_pelaksanaan', $training->tanggal_pelaksanaan) }}">
                                            @error('tanggal_pelaksanaan')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Bertempat</label>
                                            <input type="text" class="form-control" name="tempat"
                                                placeholder="Nama Tempat Contoh : Puri Lesia (Betapus)"
                                                value="{{ old('tempat', $training->tempat) }}">
                                            @error('tempat')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Category Pelatihan</label>
                                            <select name="category" class="form-control" required>
                                                <option value="">-pilih kategori pelatihan-</option>
                                                @foreach ($categories as $category)
                                                    @if (old($category->id, $training->category_id) == $category->id)
                                                        <option value="{{ $category->id }}" selected>
                                                            {{ $category->title }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
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

@push('scripts')
    @push('scripts')
        <script>
            $('#year').datetimepicker({
                format: 'YYYY',
            });
        </script>
    @endpush
@endpush
