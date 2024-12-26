@extends('layout.formApp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Add Rak Buku</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Start -->
                            <form action="{{ $rak ? route('rak.update', $rak->kode_rak) : route('rak.store') }}" method="POST">
                                @csrf
                                @if ($rak)
                                    @method('PUT')
                                @endif
                                <!-- Date -->
                                <div class="form-group">
                                    <label for="kode">Kode Rak:</label>
                                    <div class="input-group date" id="kode" name='kode'>
                                        <input type="text" id="kode" name="kode"
                                            class="form-control datetimepicker-input" data-target="#kode" placeholder="lantai_kode"
                                            value="{{ old('kode_rak', $rak->kode_rak ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lokasi">Lokasi:</label>
                                    <div class="input-group date" id="lokasi">
                                        <input type="text" id="lokasi" name="lokasi"
                                            class="form-control datetimepicker-input" data-target="#lokasi"
                                            value="{{ old('lokasi', $rak->lokasi ?? '') }}">
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
