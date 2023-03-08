@extends('auth.layouts.app')

@section('title', 'Sertifikat')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Sertifikat</h4>
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
                        <a href="{{ route('dashboard.certificate.index') }}">Sertifikat</a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            {{-- Notify --}}
            <div id="flash" data-flash="{{ session('success') }}"></div>

            <div class="row">
                <div class="col-lg-12 py-3 mb-4">
                    <a href="{{ route('dashboard.certificate.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Sertifikat
                    </a>
                </div>
                <div class="col-lg-12">
                    <form action="{{ route('dashboard.certificate.index') }}">
                        <div class="row my-4">
                            <div class="col-sm-4">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="search" placeholder="Pencarian..."
                                        value="">
                                    <span class="input-icon-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="select2-input">
                                    <select id="basic" name="category" class="form-control">
                                        <option value="">-select kategori-</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->title }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="select2-input">
                                    <select id="basic" name="training" class="form-control">
                                        <option value="">-select pelatihan-</option>
                                        @foreach ($trainings as $training)
                                            <option value="{{ $training->title }}">{{ $training->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success">
                                    <i class="fas fa-search"></i>
                                    Filter
                                </button>
                                <a href="{{ route('dashboard.certificate.index') }}" class="btn btn-black">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Code</th>
                                        <th scope="col">Nama Pelatihan</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Nama Peserta</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $certificate)
                                        <tr class="text-center">
                                            <td>{{ $certificate->code }}</td>
                                            <td>{{ $certificate->pelatihan_title }}</td>
                                            <td class="text-uppercase">{{ $certificate->kategori_title }}</td>
                                            <td>{{ $certificate->peserta_nama }}</td>
                                            <td>
                                                <form id="form-delete-{{ $certificate->id }}"
                                                    action="{{ route('dashboard.certificate.delete', $certificate->code) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                {{-- <a href="{{ route('dashboard.certificate.cetak.qrcode', $certificate->code) }}"
                                                    class="btn btn-link text-dark">
                                                    <i class="fas fa-qrcode"></i>
                                                </a> --}}
                                                @if ($certificate->kategori_title == 'pelatihan')
                                                    <a href="{{ route('dashboard.certificate.cetak.pelatihan', $certificate->code) }}"
                                                        class="btn btn-link text-success">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('dashboard.certificate.cetak.bimtek', $certificate->code) }}"
                                                        class="btn btn-link text-success">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('dashboard.certificate.edit', $certificate->code) }}"
                                                    class="btn btn-link text-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-link text-danger"
                                                    onclick="btnDelete( {{ $certificate->id }} )">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-center">
                    {{ $certificates->appends(request()->all())->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    {{-- Notify --}}
    <script>
        var flash = $('#flash').data('flash');
        if (flash) {
            $.notify({
                // options
                icon: 'fas fa-check',
                title: 'Success',
                message: '{{ session('success') }}',
            }, {
                // settings
                type: 'success'
            });
        }
    </script>

    {{-- SweetAlert Confirmation --}}
    <script>
        function btnDelete(id) {
            swal({
                title: 'Apa anda yakin?',
                text: "Data tidak dapat di kembalikan setelah ini !!!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Ya, hapus sekarang',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                    $('#form-delete-' + id).submit();
                } else {
                    swal.close();
                }
            });
        }
    </script>
@endpush
