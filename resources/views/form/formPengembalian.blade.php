@extends('layout.formApp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Pengembalian</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Start -->
                            <form
                                action="{{ $pengembalian ? route('pengembalian.update', $pengembalian->id) : route('pengembalian.store') }}"
                                method="POST">
                                @csrf
                                @if ($pengembalian)
                                    @method('PUT')
                                @endif
                                <div class="form-group">
                                    <label for="peminjaman">Peminjaman:</label>
                                    <select name="peminjaman" id="peminjaman" class="form-control" {{ isset($selectedPeminjaman) ? 'readonly' : '' }}>
                                        @if (isset($selectedPeminjaman))
                                            {{-- Opsi hanya menampilkan peminjaman terpilih --}}
                                            <option value="{{ $selectedPeminjaman }}" selected>
                                                {{ $selectedPeminjaman }} - {{ $peminjaman->firstWhere('id', $selectedPeminjaman)->anggota->nama }} 
                                                ({{ $peminjaman->firstWhere('id', $selectedPeminjaman)->tanggal_pinjam }})
                                            </option>
                                        @else
                                            {{-- Saat membuat data baru --}}
                                            <option value="" disabled selected>Pilih Peminjaman</option>
                                            @foreach ($peminjaman as $item)
                                                <option value="{{ $item->id }}" {{ old('peminjaman') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->id }} - {{ $item->anggota->nama }} ({{ $item->tanggal_pinjam }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="pengembalian">Tanggal pengembalian:</label>
                                    <div class="input-group date" id="pengembalian" data-target-input="nearest">
                                        <input type="text" id="pengembalian" name="pengembalian"
                                            class="form-control datetimepicker-input" data-target="#pengembalian"
                                            value="{{ old('pengembalian', $pengembalian->tanggal_pengembalian ?? '') }}">
                                        <div class="input-group-append" data-target="#pengembalian"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('pengembalian.index') }}" class="btn btn-danger">Back</a>
                                </div>
                            </form>
                            <!-- Form End -->
                        </div>
                        <!-- Error Modal -->
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
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
        $('#pengembalian').datetimepicker({
            format: 'DD-MM-YYYY',
            viewMode: 'days',
        });
        @if ($errors->any())
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        @endif
    </script>
@endpush
