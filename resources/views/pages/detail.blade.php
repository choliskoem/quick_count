@extends('layouts.app')

@section('title', 'Detail Data')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Data</h1>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Detail</h4>
                    <div class="card-header-action">
                        {{-- Uncomment to add action button --}}
                        {{-- <a href="{{ route('saksi.create') }}" class="btn btn-primary">Tambah Saksi</a> --}}
                    </div>
                    <div class="clearfix mb-3"></div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="wilayah">Wilayah:</label>
                        <select class="form-control select2" id="wilayah" name="id_wilayah" required>
                            <option value="">Pilih Wilayah</option>
                            @foreach ($wilayah as $wilayahItem)
                                <option value="{{ $wilayahItem->id_kabkota }}">{{ $wilayahItem->wilayah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="desa">Desa:</label>
                        <select class="form-control select2" id="desa" name="id_desa" required>
                            <option value="">Pilih Desa</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table-striped table" id="table-4">
                            <thead>
                                <tr>
                                    <th>Nomor Urut</th>
                                    <th>Nama Peserta</th>
                                    <th>Wilayah</th>
                                    <th>Tps</th>
                                    <th>Jumlah</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $result->id_peserta }}</td>
                                        <td>{{ $result->nama_peserta }}</td>
                                        <td>{{ $result->jumlah }}</td>
                                        <td>{{ $result->wilayah }}</td>
                                        <td>{{ $result->tps }}</td>
                                        <td>{{ $result->nama_desa }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#wilayah').change(function() {
                var idKabkota = $(this).val();

                // Fetch desa based on id_kabkota
                if (idKabkota) {
                    $.ajax({
                        url: '/desa/' + idKabkota,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#desa').empty().append('<option value="">Pilih Desa</option>');
                            $.each(data, function(key, value) {
                                $('#desa').append('<option value="' + value.id_desa +
                                    '" data-id-wilayah="' + value.id_wilayah +
                                    '"  data-id-kabkota="' + value.id_kabkota +
                                    '">' + value.nama_desa + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('Error fetching data for desa.');
                        }
                    });
                } else {
                    $('#desa').empty().append('<option value="">Pilih Desa</option>');
                }
            });

            $('#desa').change(function() {
                var selectedOption = $(this).find('option:selected');
                var idWilayah = selectedOption.data('id-kabkota');
                var idKabkota = $('#wilayah').val();

                // Fetch data based on selected id_wilayah and id_desa
                fetchData(idKabkota, $(this).val());
            });

            function fetchData(idKabkota, idDesa) {
                if (idKabkota && idDesa) {
                    $.ajax({
                        url: '/detail', // Update with the correct endpoint
                        type: 'GET',
                        data: {
                            id_wilayah: idKabkota,
                            id_desa: idDesa
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#table-4 tbody').empty();

                            let lastNoUrut = null;
                            let lastNamaPeserta = null;
                            let lastIdPeserta = null;
                            let lastWilayah = null;

                            $.each(data, function(index, item) {
                                let noUrutCell = '';
                                let namaPesertaCell = '';
                                let wilayahCell = '';

                                // Cek jika no_urut berbeda dari sebelumnya, baru tambahkan ke sel
                                if (item.no_urut !== lastNoUrut) {
                                    noUrutCell = '<td>' + item.no_urut + '</td>';
                                    lastNoUrut = item.no_urut;
                                } else {
                                    noUrutCell = '<td></td>';
                                }

                                // Cek jika nama_peserta berbeda dari sebelumnya, baru tambahkan ke sel
                                if (item.nama_peserta !== lastNamaPeserta) {
                                    namaPesertaCell = '<td>' + item.nama_peserta + '</td>';
                                    lastNamaPeserta = item.nama_peserta;
                                } else {
                                    namaPesertaCell = '<td></td>';
                                }

                                // Cek jika wilayah berbeda dari sebelumnya, atau idPeserta berbeda
                                if (item.wilayah !== lastWilayah || item.id_peserta !==
                                    lastIdPeserta) {
                                    wilayahCell = '<td>' + item.wilayah + '</td>';
                                    lastWilayah = item.wilayah;
                                    lastIdPeserta = item
                                    .id_peserta; // Update lastIdPeserta when a new wilayah is displayed
                                } else {
                                    wilayahCell = '<td></td>';
                                }

                                $('#table-4 tbody').append('<tr>' +
                                    noUrutCell +
                                    namaPesertaCell +
                                    wilayahCell +
                                    '<td>' + item.tps + '</td>' +
                                    '<td>' + item.jumlah + '</td>' +
                                    '</tr>');
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('Error fetching data.');
                        }
                    });
                }
            }
        });
    </script>
@endpush
