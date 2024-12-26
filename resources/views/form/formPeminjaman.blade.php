@extends('layout.formApp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Peminjaman</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Start -->
                            <form
                                action="{{ $peminjaman ? route('peminjaman.update', $peminjaman->id) : route('peminjaman.store') }}"
                                method="POST">
                                @csrf
                                @if ($peminjaman)
                                    @method('PUT')
                                @endif
                                <div class="form-group">
                                    <label for="pinjam">Tanggal Peminjaman:</label>
                                    <div class="input-group date" id="pinjam" data-target-input="nearest">
                                        <input type="text" id="pinjam" name="pinjam"
                                            class="form-control datetimepicker-input" data-target="#pinjam"
                                            value="{{ old('pinjam', $peminjaman->tanggal_pinjam ?? '') }}">
                                        <div class="input-group-append" data-target="#pinjam" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kembali">Tanggal kambali:</label>
                                    <div class="input-group date" id="kembali" data-target-input="nearest">
                                        <input type="text" id="kembali" name="kembali"
                                            class="form-control datetimepicker-input" data-target="#kembali"
                                            value="{{ old('kembali', $peminjaman->tanggal_kembali ?? '') }}">
                                        <div class="input-group-append" data-target="#kembali" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Anggota:</label>
                                    <select name="anggota" id="anggota" class="form-control">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        @foreach ($anggota as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('anggota', $peminjaman->anggota_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="petugas">Petugas:</label>
                                    <select name="petugas" id="petugas" class="form-control">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        @foreach ($petugas as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('petugas', $peminjaman->petugas_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buku">Buku:</label>
                                    <select name="buku" id="buku" class="form-control">
                                        <option value="" disabled selected>Pilih Buku</option>
                                        @foreach ($buku as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('buku', $selectedBook ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->buku }} (Jumlah: {{ $item->jumlah }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#pinjam , #kembali').datetimepicker({
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
