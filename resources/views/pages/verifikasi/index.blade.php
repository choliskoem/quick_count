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
            <div class="card">
                <div class="card-header">
                    <h4>Verifikasi</h4>
                    <div class="card-header-action">
                        {{-- <a href="{{ route('saksi.create') }}" class="btn btn-primary">
                            Tambah Saksi
                        </a> --}}
                    </div>

                    <div class="clearfix mb-3"></div>

                </div>
                <div class="card-body">
                    <div class="float-right">
                        <form method="GET" action="{{ route('saksi.index') }}">
                            {{-- <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div> --}}
                        </form>
                    </div>



                    <div class="table-responsive">
                        <table class="table-striped table" id="table-2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Desa</th>
                                    <th scope="col">Tps</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $verif)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $verif->nama_desa }}</td>
                                        <td>{{ $verif->tps }}</td>
                                        <td>{{ $verif->created_at }}</td>
                                        <td>
                                            <a href="{{ route('verif.create', ['id' => $verif->id_wilayah_saksi]) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="float-right">
                        {{-- {{ $result->withQueryString()->links() }} --}}
                    </div>
                </div>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

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
