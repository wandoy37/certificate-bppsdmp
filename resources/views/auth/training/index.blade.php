@extends('auth.layouts.app')

@section('title', 'Pelatihan')

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
                    <a href="{{ route('dashboard.training.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Pelatihan
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nama Pelatihan</th>
                                        <th scope="col">Angkatan</th>
                                        <th scope="col">Tahun</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainings as $training)
                                        <tr>
                                            <td>{{ $training->title }}</td>
                                            <td class="text-center">{{ $training->batch }}</td>
                                            <td class="text-center">{{ $training->year }}</td>
                                            <td class="text-center d-flex justify-content-center">
                                                <div class="form-inline">
                                                    <a href="{{ route('dashboard.training.edit', $training->slug) }}"
                                                        class="btn btn-outline-warning btn-round">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <div class="ml-2">
                                                        <form id="form-delete-{{ $training->id }}"
                                                            action="{{ route('dashboard.training.delete', $training->slug) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-round"
                                                            onclick="btnDelete( {{ $training->id }} )">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
