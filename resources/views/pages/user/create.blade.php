@extends('layouts.app')

@section('title', 'User')

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
                <h1>Penginputan User Baru</h1>
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

                            <form action="/user/store" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_saksi">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_saksi">Username</label>
                                    <input type="text" class="form-control" id="nama_saksi" name="username" required>
                                </div>


                                <div class="form-group">
                                    <label for="nama_saksi">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="desa">Wilayah:</label>
                                    <select class="form-control select2" id="id_level" name="id_level" required>

                                        <option value="">Pilih Wilayah</option>
                                        @foreach ($result as $levels)
                                            <option value="{{ $levels->id_level }}">{{ $levels->level }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="form-group">
                                    <label for="tps">Wilayah</label>
                                    <select class="form-control select2" name="id_kabkota[]" multiple="multiple" required>

                                        <option value="">Pilih Wilayah</option>
                                        @foreach ($result as $kab)
                                            <option value="{{ $kab->id_kabkota }}">{{ $kab->wilayah }}</option>
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



    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="pilgub">
    <label class="form-check-label" for="inlineCheckbox1">pilgub</label>







    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}





    <!-- Page Specific JS File -->
@endpush
