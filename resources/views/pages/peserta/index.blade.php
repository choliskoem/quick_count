@extends('layouts.app')

@section('title', 'Peserta')

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
                <h1>Peserta</h1>
            </div>

            <div class="section-body">
                <div class="container mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h2>Penginputan Peserta</h2>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif


                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>


@endsection

@push('scripts')
    <!-- JS Libraies -->

    {{-- <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script> --}}
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





    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}





    <!-- Page Specific JS File -->
@endpush
