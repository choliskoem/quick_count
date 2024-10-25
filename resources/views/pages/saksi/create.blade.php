@extends('layouts.app')

@section('title', 'Saksi')

@push('style')
    <!-- CSS Libraries -->

    <link rel="stylesheet" href="/library/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="/library/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/library/selectric/public/selectric.css">
    <link rel="stylesheet" href="/library/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
@endpush

@section('main')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penginputan Saksi</h1>
            </div>

            <div class="section-body">
                {{-- @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
                <div class="container mt-5">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h4>Penginputan Saksi</h4> --}}
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="/saksi/store" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_saksi">Nama Saksi:</label>
                                    <input type="text" class="form-control" id="nama_saksi" name="nama_saksi" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No Handphone:</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                    @if ($errors->has('no_hp'))
                                        <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="desa">Wilayah:</label>
                                    {{-- <select class="form-control select2" id="desa" name="desa" required>
                                        @foreach ($desa as $desanama)
                                            <option value="{{ $desanama->id_desa }}">{{ $desanama->nama_desa }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select class="form-control select2" id="wilayah" required>

                                        <option value="">Pilih Wilayah</option>
                                        @foreach ($wilayah as $wilayah)
                                            <option value="{{ $wilayah->id_kabkota }}">{{ $wilayah->wilayah }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" id="id_wilayah" name="id_wilayah">


                                <div class="form-group">
                                    <label for="desa">Desa:</label>

                                    <select class="form-control select2" id="desa" name="id_desa" required>
                                        <option value="">Pilih Desa</option>
                                    </select>


                                </div>


                                <div class="form-group">
                                    <label class="d-block">Bagian Pemilu:</label>
                                    <div id="bagian-pemilu-checkboxes2" class="form-check form-check-inline  col-ml-2  ">

                                    </div>
                                    <div id="bagian-pemilu-checkboxes" class="form-check form-check-inline">
                                        <!-- Checkbox akan muncul di sini -->
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label for="tps">Tps:</label>
                                    <select class="form-control select2" name="tps[]" multiple="multiple" required>

                                        <option value="">Pilih Wilayah</option>
                                        @foreach ($tpsList as $tps)
                                            <option value="{{ $tps->id_tps }}">{{ $tps->tps }}</option>
                                        @endforeach
                                    </select>
                                </div>




                                {{-- <input type="hidden" name="waktu" value="{{ now() }}"> --}}
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    {{-- <p class="mb-0 ml-auto"><strong>Rp. {{ number_format($sum, 0, ',', '.') }}</strong></p> --}}
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>


@endsection

@push('scripts')
    <!-- JS Libraies -->

    {{-- <script src="/library/jquery/dist/jquery.min.js"></script> --}}
    <script src="/library/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/library/cleave.js/dist/cleave.min.js"></script>
    <script src="/library/cleave.js/dist/addons/cleave-phone.us.js"></script>
    <script src="/library/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/library/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/library/select2/dist/js/select2.full.min.js"></script>
    <script src="/library/selectric/public/jquery.selectric.min.js"></script>
    <script src="/library/izitoast/dist/js/iziToast.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="/js/page/modules-toastr.js"></script>


    <!-- Page Specific JS File -->
    <script src="/js/page/forms-advanced-forms.js"></script>
    <script src="/js/page/bootstrap-modal.js"></script>




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

    <script>
        $(document).ready(function() {
            $('#wilayah').change(function() {
                var id_kabkota = $(this).val();

                // Mengambil desa berdasarkan id_kabkota
                if (id_kabkota) {
                    // Tambahkan input hidden wilayah dengan value dari id_kabkota
                    $.ajax({
                        url: '/desa/' + id_kabkota,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#desa').empty(); // Mengosongkan dropdown desa
                            $('#desa').append(
                                '<option value="">Pilih Desa</option>'
                            ); // Menambah opsi default

                            // Tambahkan id_wilayah dan id_desa dalam setiap opsi
                            $.each(data, function(key, value) {
                                $('#desa').append('<option value="' + value.id_desa +
                                    '" data-id-wilayah="' + value.id_wilayah +
                                    '">' + value.nama_desa + '</option>');
                            });
                        }
                    });
                } else {
                    $('#desa').empty();
                    $('#desa').append('<option value="">Pilih Desa</option>');
                }
            });

            // Event listener untuk menangani perubahan pada dropdown desa
            $('#desa').change(function() {
                var selectedOption = $(this).find('option:selected');
                var idWilayah = selectedOption.data(
                    'id-wilayah'); // Mengambil id_wilayah dari opsi yang dipilih
                $('#id_wilayah').val(idWilayah); // Mengatur nilai id_wilayah
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#wilayah').change(function() {
                var id_kabkota = $(this).val();

                // Memuat bagian pemilu berdasarkan id_kabkota
                if (id_kabkota) {
                    $.ajax({
                        url: '/bagian-pemilu/' + id_kabkota,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#bagian-pemilu-checkboxes').empty(); // Kosongkan area checkbox

                            // Buat checkbox berdasarkan data




                            $.each(data, function(key, value) {
                                $('#bagian-pemilu-checkboxes2').append(
                                    '<input class="form-check-input" type="checkbox" id="checkbox' +
                                    value.id_kabkota +
                                    '"  value="7" name="id_kabkota[]">' +
                                    '<label class="form-check-label" for="checkbox' +
                                    value.id_bagian_pemilu + '">pilgub</label>'
                                );
                                $('#bagian-pemilu-checkboxes').append(
                                    '<input class="form-check-input" type="checkbox" id="checkbox' +
                                    value.id_kabkota +
                                    '" name="id_kabkota[]" value="' +
                                    value.id_kabkota + '">' +
                                    '<label class="form-check-label" for="checkbox' +
                                    value.id_bagian_pemilu + '">' +
                                    value.label + '</label>'
                                );
                            });

                            // Menambahkan checkbox untuk 'pilgub'

                        }
                    });
                } else {
                    $('#bagian-pemilu-checkboxes')
                        .empty(); // Kosongkan checkbox jika tidak ada wilayah yang dipilih
                }
            });
        });
    </script>

    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="pilgub">
    <label class="form-check-label" for="inlineCheckbox1">pilgub</label>







    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}





    <!-- Page Specific JS File -->
@endpush
