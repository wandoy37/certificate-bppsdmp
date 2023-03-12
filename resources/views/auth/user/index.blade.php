@extends('auth.layouts.app')

@section('title', 'Pengguna')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pengguna</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard.user.index') }}">
                            <i class="fas fa-users-cog"></i>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Notify --}}
            <div id="flash" data-flash="{{ session('success') }}"></div>

            {{-- Fails --}}
            <div id="fails" data-flash="{{ session('fails') }}"></div>

            <div class="row">
                <div class="col-lg-12 py-3 mb-4">
                    <a href="{{ route('dashboard.user.create') }}" class="btn btn-outline-success btn-round">
                        <i class="fas fa-plus"></i>
                        Pengguna
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <div class="form-inline">
                                                    <a href="{{ route('dashboard.user.edit', $user->slug) }}"
                                                        class="btn btn-outline-warning btn-round">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <div class="ml-2">
                                                        <form id="form-delete-{{ $user->id }}"
                                                            action="{{ route('dashboard.user.delete', $user->slug) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-round"
                                                            onclick="btnDelete( {{ $user->id }} )">
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
                <div class="col-lg-12 d-flex justify-content-center">
                    {{ $users->appends(request()->all())->links('pagination::bootstrap-4') }}
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

        var flash = $('#fails').data('flash');
        if (flash) {
            swal("Error", "{{ session('fails') }}", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                },
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
