@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Peserta</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="card">
                <form action="{{ route('peserta.create') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah Peserta</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Bagian Pemilu</label>
                            <select class="form-control select2 @error('bagian-pemilu') is-invalid @enderror"
                                name="bagian-pemilu">
                                <option value="">Pilih Bagian Pemilu</option>
                                @foreach ($bagianPemilu as $row)
                                    <option value="{{ $row->id_bagian_pemilu }}"
                                        @if ($row->id_bagian_pemilu == old('bagian-pemilu')) selected @endif>
                                        {{ strtoupper($row->label) . ' - ' . $row->kabkota->wilayah }}</option>
                                @endforeach
                            </select>
                            @error('bagian-pemilu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor Urut</label>
                            <input type="number" class="form-control @error('no-urut') is-invalid @enderror" name="no-urut"
                                value="{{ old('no-urut') }}">
                            @error('no-urut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Peserta Posisi 1</label>
                            <input type="text" class="form-control @error('nama-posisi-1') is-invalid @enderror"
                                name="nama-posisi-1" value="{{ old('nama-posisi-1') }}">
                            @error('nama-posisi-1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Peserta Posisi 2</label>
                            <input type="text" class="form-control @error('nama-posisi-2') is-invalid @enderror"
                                name="nama-posisi-2" value="{{ old('nama-posisi-2') }}">
                            @error('nama-posisi-2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control is-invalid" required="" value="rizal@fakhri">
                            <div class="invalid-feedback">
                                Oh no! Email is invalid.
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>


    <!-- Page Specific JS File -->
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
@endpush
