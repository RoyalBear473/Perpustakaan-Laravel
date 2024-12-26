@extends('layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>buku</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Buku</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 130px;">
                                    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Buku</th>
                                        <th>Tahun Terbit</th>
                                        <th>Jumlah</th>
                                        <th>ISBN</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Kode Rak</th>
                                        <th>Lokasi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->buku }}</td>
                                            <td>{{ $item->tahun_terbit }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>{{ $item->isbn }}</td>
                                            <td>{{ $item->pengarang->nama }}</td>
                                            <td>{{ $item->penerbit->nama }}</td>
                                            <td>{{ $item->rak->kode_rak }}</td>
                                            <td>{{ $item->rak->lokasi }}</td>
                                            <td>
                                                <a href="{{ route('buku.edit', $item->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        document.getElementById('dataForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');
            const url = id ? `/buku/update/${id}` : '/buku/store';
            const method = id ? 'PUT' : 'POST';

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Gagal menyimpan data');
                    }
                })
                .catch(err => console.error(err));
        });

        function editData(id) {
            fetch(`/buku/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Isi form modal dengan data buku
                    document.getElementById('id').value = data.id;
                    document.getElementById('buku').value = data.buku;
                    document.getElementById('tahun_terbit').value = data.tahun_terbit;
                    // Tampilkan modal
                    new bootstrap.Modal(document.getElementById('formModal')).show();
                });
        }
    </script>
@endsection
