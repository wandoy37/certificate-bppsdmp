@extends('home.layouts.app')

@section('title', 'Category ' . $category->title)

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">

            <div class="col-lg-12">
                <a href="http://" class="btn btn-outline-dark">
                    <i class="fas fa-undo"></i>
                    Kembali
                </a>
            </div>

            <h3 class="text-center py-4">List Pelatihan</h3>
            <div class="col-lg-8">
                <table class="table table-hover table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pelatihan</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="text-center">1</th>
                            <td>Pelatihan Agribisnis Tanaman Pangan dan Hortikultura</td>
                            <td class="text-center">2023</td>
                            <td class="text-center">
                                <a href="http://" class="btn btn-warning">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
