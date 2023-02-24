<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ghufta Service | @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('atlantis/img/icon.ico') }}" type="image/x-icon" />

    {{-- Popins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Fonts and icons -->
    <script src="{{ asset('atlantis/js/plugin/webfont/webfont.min.js') }}"></script>
    {{-- <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('atlantis/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script> --}}

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('atlantis/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('atlantis/css/atlantis.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('atlantis/css/demo.css') }}">
</head>

<style>
    @media print {

        html,
        body {
            display: block;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        @page {
            size: 21cm 29.7cm;
        }

        @media print {
            @page {
                size: landscape
            }
        }
    }
</style>

<body>
    {{-- Section content --}}
    <div class="container pt-4">
        <section id="cetakResi">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-invoice">
                        <div class="card-body">
                            <div class="row" style="margin-top: 220px;">
                                <div class="col-lg-12 info-invoice">
                                    <h5 class="text-center">Nomor : 000.9.4 / {{ $peserta->id }} / BPPSDMP /
                                        {{ date('Y') }}</h5>
                                    <p>Pemerintah Provinsi Kalimantan Timur, menyatakan bahwa :</p>
                                    <div class="row no-gutters">
                                        {{-- <div class="col-md-2 float-right">
                                            <img src="{{ asset('atlantis/img/profile2.jpg') }}" class="img-fluid"
                                                alt="...">
                                        </div> --}}
                                        <div class="col-md-10" style="margin-left: 125px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-5">Nama</div>
                                                    <div class="col-sm-7">: {{ $peserta->name }}</div>
                                                    <div class="col-sm-5">NIP</div>
                                                    <div class="col-sm-7">: {{ $peserta->nip }}</div>
                                                    <div class="col-sm-5">Tempat, Tanggal Lahir</div>
                                                    <div class="col-sm-7">: {{ $peserta->birth }}</div>
                                                    <div class="col-sm-5">Pangkat/Golongan</div>
                                                    <div class="col-sm-7">: {{ $peserta->pangkat_golongan }}</div>
                                                    <div class="col-sm-5">Jabatan</div>
                                                    <div class="col-sm-7">: {{ $peserta->jabatan }}</div>
                                                    <div class="col-sm-5">Asal Instansi</div>
                                                    <div class="col-sm-7">: {{ $peserta->instansi }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h3 class="text-center" style="color: #093c82;"><b>TELAH MENGIKUTI</b></h3>
                                    <p class="text-center">
                                        Telah mengikuti pelatihan {{ $peserta->training->title }}
                                        Angkatan Ke yang diselenggarakan di <b>UPTD BPPSDMP Provinsi
                                            Kalimantan Timur</b> <br> dari tanggal
                                        {{ Carbon\Carbon::parse($peserta->training->start_date)->translatedFormat('d F') }}
                                        s.d
                                        {{ Carbon\Carbon::parse($peserta->training->end_date)->translatedFormat('d F') }}
                                        dengan jumlah {{ $peserta->training->hour }}
                                        jam berlatih
                                    </p>
                                </div>
                                <div class="col-lg-12">
                                    <div class="my-2">
                                        <div class="row">
                                            <div class="col-sm-4" style="margin-left: 20px;">
                                                {!! QrCode::size(70)->generate(route('show.participant', $peserta->slug)) !!}
                                            </div>
                                            {{-- <div class="col-sm-4" style="float: right;">
                                                Samarinda, {{ date('d M Y') }}
                                                <p>Kepala Dinas,</p>
                                                <div class="kadis" style="padding-top: 25px;">
                                                    <span>Ir. Siti Farisyah Yana, M.Si</span> <br>
                                                    <span>PEMBINA UTAMA MUDA/IV.c</span> <br>
                                                    <span>NIP. 19690516 199301 2 001</span>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- /Section content --}}


    <!--   Core JS Files   -->
    <script src="{{ asset('atlantis/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis') }}/js/core/bootstrap.min.js"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

    <script>
        window.print();
    </script>
</body>

</html>
