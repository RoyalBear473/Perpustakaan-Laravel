@extends('layout.formApp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Add Buku</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Start -->
                            <form action="{{ $buku ? route('buku.update', $buku->id) : route('buku.store') }}" method="POST">
                                @csrf
                                @if ($buku)
                                    @method('PUT')
                                @endif
                                <!-- Date -->
                                <div class="form-group">
                                    <label for="buku">Buku:</label>
                                    <div class="input-group date" id="buku" nama>
                                        <input type="text" id="buku" name="buku"
                                            class="form-control datetimepicker-input" data-target="#buku"
                                            value="{{ old('buku', $buku->buku ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Tahun Terbit:</label>
                                    <div class="input-group date" id="tahun_terbit" data-target-input="nearest">
                                        <input type="text" id="tahun" name="tahun"
                                            class="form-control datetimepicker-input" data-target="#tahun_terbit"
                                            value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}">
                                        <div class="input-group-append" data-target="#tahun_terbit"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah:</label>
                                    <div class="input-group">
                                        <input type="text" id="jumlah" name="jumlah" class="form-control float-right"
                                            value="{{ old('jumlah', $buku->jumlah ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN:</label>
                                    <div class="input-group">
                                        <input type="text" id="isbn" name="isbn" class="form-control float-right"
                                            value="{{ old('isbn', $buku->isbn ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pengarang">Pengarang:</label>
                                    <select name="pengarang" id="pengarang" class="form-control">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        @foreach ($pengarang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('pengarang', $buku->pengarang_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="penerbit">Penerbit:</label>
                                    <select name="penerbit" id="penerbit" class="form-control">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        @foreach ($penerbit as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('penerbit', $buku->penerbit_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rak">Rak:</label>
                                    <select name="rak" id="rak" class="form-control">
                                        <option value="" disabled selected>Pilih salah satu</option>
                                        @foreach ($rak as $item)
                                            <option value="{{ $item->kode_rak }}"
                                                {{ old('rak', $buku->kode_rak ?? '') == $item->kode_rak ? 'selected' : '' }}>
                                                {{ $item->kode_rak }}</option>
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
        function toggleDropdown(id) {
            // Tutup semua dropdown
            const dropdowns = document.querySelectorAll('[id^="dropdown"]');
            dropdowns.forEach(dropdown => {
                if (dropdown.id !== id) {
                    dropdown.style.display = 'none';
                }
            });

            // Tampilkan atau sembunyikan dropdown yang diklik
            const currentDropdown = document.getElementById(id);
            if (currentDropdown.style.display === 'none' || !currentDropdown.style.display) {
                currentDropdown.style.display = 'block';
            } else {
                currentDropdown.style.display = 'none';
            }
        }
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
