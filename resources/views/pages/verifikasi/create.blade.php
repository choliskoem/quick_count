@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Verifikasi</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="text-center mb-4">
                @if ($fileCi1Url)
                    <a href="{{ $fileCi1Url }}" target="_blank">
                        <img src="{{ $fileCi1Url }}" alt="File C1 Image" class="img-fluid">
                    </a>
                @else
                    <p>File C1 tidak tersedia.</p>
                @endif

                @if ($filePapanUrl)
                    <a href="{{ $filePapanUrl }}" target="_blank">
                        <img src="{{ $filePapanUrl }}" alt="File Papan Image" class="img-fluid">
                    </a>
                @else
                    <p>File Papan tidak tersedia.</p>
                @endif
            </div>

            <!-- Card Section -->
            <div class="card">
                <div class="card-header">
                    <h4>Verifikasi</h4>
                    <div class="card-header-action"></div>
                    <div class="clearfix mb-3"></div>
                </div>
                <div class="card-body">
                    <div class="float-right">
                        <form method="GET" action="{{ route('saksi.index') }}">
                            <!-- Optional Search Form -->
                        </form>
                    </div>

                    <form action="{{ route('verif.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_wilayah_saksi" value="{{ request()->query('id') }}">
                        <div class="table-responsive">
                            <table class="table-striped table" id="table-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Paslon</th>
                                        <th scope="col">Wa</th>
                                        <th scope="col">C1</th>
                                        <th scope="col">Papan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $verif)
                                        <tr>
                                            <input type="hidden" name="id_peserta[]" value="{{ $verif->id_peserta }}">
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $verif->nama_peserta }}</td>
                                            <td>{{ $verif->jumlah }}</td>
                                            <td><input type="number" name="jumlah_c1[]" class="form-control"></td>
                                            <td><input type="number" name="jumlah_papan[]" class="form-control"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </form>

                    <div class="float-right">
                        <!-- Pagination -->
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
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS Files -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>

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
        function showImageModal(imageUrl) {
            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').modal('show');
        }
    </script>
@endpush
