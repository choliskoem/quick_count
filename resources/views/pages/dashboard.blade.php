@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="row">
                {{-- <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Line Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div> --}}
                <div class=" col-md-6 col-lg-6 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pemilihan Gubernur</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartpilgub"></canvas>
                        </div>
                    </div>
                </div>

                <div class=" col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pemilihan Kabupaten / Kota</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartpilkabkota"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Admin</h4>
                            </div>
                            <div class="card-body">
                                10
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>News</h4>
                            </div>
                            <div class="card-body">
                                42
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Reports</h4>
                            </div>
                            <div class="card-body">
                                1,201
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Online Users</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <h1>Selamat</h1> --}}

        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>

    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>




    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>

    <script>
        const ctx = document.getElementById("chartpilgub");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: {!! json_encode($labels) !!}, // Labels from the SQL query
                datasets: [{
                        label: "Suara Sudah Verifikasi",
                        data: {!! json_encode($verifData) !!}, // Data for "Suara Masuk"
                        borderWidth: 2,
                        backgroundColor: "#6777ef",
                        borderColor: "#6777ef",
                        borderWidth: 2.5,
                        pointBackgroundColor: "#ffffff",
                        pointRadius: 4,
                    },
                    {
                        label: "Suara Belum Verifikasi",
                        data: {!! json_encode($belumverifData) !!}, // Data for "Suara Belum Masuk"
                        borderWidth: 2,
                        backgroundColor: "#ffff00",
                        borderColor: "#ffff00",
                        borderWidth: 2.5,
                        pointBackgroundColor: "#ffffff",
                        pointRadius: 4,
                    },
                ],
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: "#f2f2f2",
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 150,
                        },
                    }, ],
                    xAxes: [{
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            display: false,
                        },
                    }, ],
                },
            },
        });




        const ctx2 = document.getElementById("chartpilkabkota");

        new Chart(ctx2, {
            type: "bar",
            data: {
                labels: {!! json_encode($labelskabkota) !!}, // Labels from the SQL query
                datasets: [{
                        label: "Suara Sudah Verifikasi",
                        data: {!! json_encode($masukVerifkabkota) !!}, // Data for "Suara Masuk"
                        borderWidth: 2,
                        backgroundColor: "#6777ef",
                        borderColor: "#6777ef",
                        borderWidth: 2.5,
                        pointBackgroundColor: "#ffffff",
                        pointRadius: 4,
                    },
                    {
                        label: "Suara Belum Verifikasi",
                        data: {!! json_encode($belumVerifkabkota) !!}, // Data for "Suara Belum Masuk"
                        borderWidth: 2,
                        backgroundColor: "#ffff00",
                        borderColor: "#ffff00",
                        borderWidth: 2.5,
                        pointBackgroundColor: "#ffffff",
                        pointRadius: 4,
                    },
                ],
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: "#f2f2f2",
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 150,
                        },
                    }, ],
                    xAxes: [{
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            display: false,
                        },
                    }, ],
                },
            },
        });
    </script>

    <script>
        @if (Session::has('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ Session::get('success') }}',
                position: 'topRight'
            });
        @endif

        @if (Session::has('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ Session::get('error') }}',
                position: 'topRight'
            });
        @endif
    </script>
@endpush
