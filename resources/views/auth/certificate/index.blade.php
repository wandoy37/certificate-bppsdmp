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
                    {{-- <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Pages</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Starter Page</a>
                    </li> --}}
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
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nama Pelatihan</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Nama Peserta</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $certificate)
                                        <tr>
                                            <td>{{ $certificate->training->title }}</td>
                                            <td>{{ $certificate->training->category->title }}</td>
                                            <td>{{ $certificate->participant->name }}</td>
                                            <td class="text-center">
                                                <form id="form-delete-{{ $certificate->id }}"
                                                    action="{{ route('dashboard.certificate.delete', $certificate->code) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @if ($certificate->training->category->title == 'pelatihan')
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
                <div class="col-lg-12">
                    {{ $certificates->links('pagination::bootstrap-4') }}
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
