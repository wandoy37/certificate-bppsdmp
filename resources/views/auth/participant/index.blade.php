@extends('auth.layouts.app')

@section('title', 'Peserta')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Peserta</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.participant.index') }}">
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
                    <a href="{{ route('dashboard.participant.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Peserta
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="row my-4">
                        <div class="col-sm-6">
                            <form action="{{ route('dashboard.participant.index') }}">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Cari nama peserta..." value="{{ $search }}">
                                    <span class="input-icon-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nama Peserta</th>
                                        <th scope="col">NIP</th>
                                        <th scope="col">NIK</th>
                                        <th scope="col">Pangkat/Golongan</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->name }}</td>
                                            <td class="text-center">{{ $participant->nip }}</td>
                                            <td class="text-center">{{ $participant->nik }}</td>
                                            <td class="text-center">{{ $participant->pangkat_golongan }}</td>
                                            <td class="text-center">{{ $participant->jabatan }}</td>
                                            <td class="text-center">
                                                <form id="form-delete-{{ $participant->id }}"
                                                    action="{{ route('dashboard.participant.delete', $participant->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="{{ route('dashboard.participant.edit', $participant->slug) }}"
                                                    class="btn btn-link text-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-link text-danger"
                                                    onclick="btnDelete( {{ $participant->id }} )">
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
                    {{ $participants->links('pagination::bootstrap-4') }}
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
