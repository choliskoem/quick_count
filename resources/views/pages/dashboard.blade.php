@extends('layouts.app')

@section('title', 'Grafik Data')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Grafik Data</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="row">
                <!-- Pemilihan Gubernur Chart -->
                @if ($penggunaWilayah->where('id_kabkota', 7)->count() > 0)
                    <div class="col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pemilihan Gubernur</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartGubernur"></canvas> <!-- Unique ID for Gubernur chart -->
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pemilihan Kabupaten Chart -->
                @if ($penggunaWilayah->where('id_kabkota', '!=', 7)->count() > 0)
                    <!-- Check if there are any records -->
                    @foreach ($dataKabupaten->groupBy('id_kabkota') as $id_kabkota => $kabupatenGroup)
                        <div class="col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pemilihan {{ $kabupatenGroup->first()->wilayah }}</h4>
                                    <!-- Display the wilayah name -->
                                </div>
                                <div class="card-body">

                                    <canvas id="chartKabupaten_{{ $id_kabkota }}"></canvas>
                                    <!-- Unique canvas ID per kabupaten -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <script>
        // Pemilihan Gubernur Chart
        // Pemilihan Gubernur Chart
        var dataGubernur = @json($dataGubernur);
        var dataGubernur2 = @json($dataGubernur2);

        // Extract labels and data values
        var labels1 = dataGubernur.map(function(item) {
            return item.nama_peserta; // Extract labels from dataGubernur
        });

        var labels2 = dataGubernur2.map(function(item) {
            return item.nama_peserta; // Extract labels from dataGubernur2
        });

        // Combine labels into a single array with unique values
        var combinedLabels = Array.from(new Set([...labels1, ...labels2]));

        // Extract data values for each dataset
        var dataValues = dataGubernur.map(function(item) {
            return item.jumlah; // Extract jumlah for dataGubernur
        });

        var dataValues2 = dataGubernur2.map(function(item) {
            return item.jumlah; // Extract jumlah for dataGubernur2
        });

        var ctx = document.getElementById("chartGubernur");
        if (ctx) {
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: combinedLabels, // Use dynamic labels
                    datasets: [{
                            label: 'Data Verifikasi',
                            data: dataValues, // Use dynamic data
                            borderWidth: 2,
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 4
                        },
                        {
                            label: 'Belum Verifikasi',
                            data: dataValues2, // Use dynamic data
                            borderWidth: 2,
                            backgroundColor: '#FFFF00',
                            borderColor: '#FFFF00',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 4
                        }
                    ],
                },

                options: {
                    responsive: true,
                    // maintainAspectRatio: false,
                    // legend: {
                    //     display: false
                    // },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 25
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                display: true, // Change this to true to display labels
                                font: {
                                    size: 12, // Optional: Adjust font size if needed
                                }
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                }
            });
        }
    </script>




    <script>
        var kabupatenData1 = @json($dataKabupaten); // First dataset
        var kabupatenData2 = @json($dataKabupaten2); // Second dataset

        // Combine the data for each `id_kabkota`
        var combinedData = {};

        // Add data from kabupatenData1
        kabupatenData1.forEach(function(item) {
            if (!combinedData[item.id_kabkota]) {
                combinedData[item.id_kabkota] = {
                    wilayah: item.wilayah,
                    data1: [],
                    data2: []
                };
            }
            combinedData[item.id_kabkota].data1.push({
                nama_peserta: item.nama_peserta,
                jumlah: item.jumlah
            });
        });

        // Add data from kabupatenData2
        kabupatenData2.forEach(function(item) {
            if (!combinedData[item.id_kabkota]) {
                combinedData[item.id_kabkota] = {
                    wilayah: item.wilayah,
                    data1: [],
                    data2: []
                };
            }
            combinedData[item.id_kabkota].data2.push({
                nama_peserta: item.nama_peserta,
                jumlah: item.jumlah
            });
        });

        // Now create the chart for each kabupaten
        Object.keys(combinedData).forEach(function(id_kabkota) {
            var dataForKabupaten = combinedData[id_kabkota];

            // Prepare labels and datasets for the chart
            var labels = dataForKabupaten.data1.map(function(item) {
                return item.nama_peserta;
            });

            var dataValues1 = dataForKabupaten.data1.map(function(item) {
                return item.jumlah;
            });

            var dataValues2 = dataForKabupaten.data2.map(function(item) {
                return item.jumlah;
            });

            // Create chart
            var ctx2 = document.getElementById("chartKabupaten_" + id_kabkota).getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labels, // Dynamic labels for this kabupaten
                    datasets: [{
                        label: 'Data Verifikasi',
                        data: dataValues1, // Data from kabupatenData1
                        borderWidth: 2,
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }, {
                        label: 'Data Belum Verifikasi',
                        data: dataValues2, // Data from kabupatenData2
                        borderWidth: 2,
                        backgroundColor: '#ffff00',
                        borderColor: '#ffff00',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    // maintainAspectRatio: false,
                    // legend: {
                    //     display: false
                    // },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 25
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                display: true, // Change this to true to display labels
                                font: {
                                    size: 12, // Optional: Adjust font size if needed
                                }
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                }
            });
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
