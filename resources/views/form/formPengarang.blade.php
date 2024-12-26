@extends('layout.formApp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Add Pengarang</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Start -->
                            <form action="{{ $pengarang ? route('pengarang.update', $pengarang->id) : route('pengarang.store') }}" method="POST">
                                @csrf
                                @if ($pengarang)
                                    @method('PUT')
                                @endif
                                <!-- Date -->
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <div class="input-group date" id="nama" nama>
                                        <input type="text" id="nama" name="nama"
                                            class="form-control datetimepicker-input" data-target="#nama"
                                            value="{{ old('nama', $pengarang->nama ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <div class="input-group date" id="alamat">
                                        <input type="text" id="alamat" name="alamat"
                                            class="form-control datetimepicker-input" data-target="#alamat"
                                            value="{{ old('alamat', $pengarang->alamat ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telp">No. Telepon:</label>
                                    <div class="input-group">
                                        <input type="text" id="telp" name="telp" class="form-control float-right"
                                            value="{{ old('telp', $pengarang->telp ?? '') }}">
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <!-- Form End -->
                        </div>
                    </div>
                    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog"
                        aria-labelledby="errorModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="errorModalLabel">Kesalahan Validasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display Errors -->
                                    @if ($errors->any())
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        @if ($errors->any())
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        @endif
        $('#tahun_terbit').datetimepicker({
            format: 'YYYY', // Hanya tahun
            viewMode: 'years', // Tampilan awal langsung ke mode tahun
        });
    </script>
@endpush
