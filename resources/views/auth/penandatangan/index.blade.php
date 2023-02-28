@extends('auth.layouts.app')

@section('title', 'Penandatangan')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Penandatangan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fas fa-user-check"></i>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- <div class="page-category">Inner page content goes here</div> --}}

            {{-- Notify --}}
            <div id="flash" data-flash="{{ session('success') }}"></div>

            <div class="row">
                <div class="col-lg-12 py-3 mb-4">
                    <a href="{{ route('dashboard.penandatangan.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Penandatangan
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nama</th>
                                        <th scope="col">NIP</th>
                                        <th scope="col">Pangkat/Golongan</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penandatangans as $penandatangan)
                                        <tr class="text-center">
                                            <td>{{ $penandatangan->name }}</td>
                                            <td>{{ $penandatangan->nip }}</td>
                                            <td>{{ $penandatangan->pangkat_golongan }}</td>
                                            <td>{{ $penandatangan->jabatan }}</td>
                                            <td>
                                                <form id="form-delete-{{ $penandatangan->id }}"
                                                    action="{{ route('dashboard.penandatangan.delete', $penandatangan->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="{{ route('dashboard.penandatangan.edit', $penandatangan->slug) }}"
                                                    class="btn btn-link text-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-link text-danger"
                                                    onclick="btnDelete( {{ $penandatangan->id }} )">
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
