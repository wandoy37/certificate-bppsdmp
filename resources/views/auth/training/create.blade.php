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
                        <a href="{{ route('dashboard.training.create') }}">Create</a>
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
                            <form action="{{ route('dashboard.training.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" class="form-control" name="code" placeholder="Code ..."
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Pelatihan</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Nama Pelatihan ..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="text" class="form-control" name="year" id="year"
                                                placeholder="Tahun ..." required>
                                        </div>
                                        <div class="form-group">
                                            <label>Durasi Pelatihan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="hour"
                                                    placeholder="Durasi Pelatihan ...">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Jam</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Pelaksanaan</label>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="datepicker_awal"
                                                        name="datepicker_awal">
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">s.d.</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="datepicker_akhir"
                                                            name="datepicker_akhir">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Bertempat</label>
                                            <input type="text" class="form-control" name="tempat"
                                                placeholder="Nama Tempat Contoh : Puri Lesia (Betapus)">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Pelatihan</label>
                                            <select name="category" class="form-control" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-success btn-round float-right">
                                                <i class="fas fa-plus"></i>
                                                Added
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
    <script>
        $('#year').datetimepicker({
            format: 'YYYY',
        });

        $('#datepicker_awal').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('#datepicker_akhir').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    </script>
@endpush
