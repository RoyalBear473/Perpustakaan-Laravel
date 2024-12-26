@extends('layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengembalian</h1>
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
                            <h3 class="card-title">Data Pengembalian Buku</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm mt-1" style="width: 200px;">
                                    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">Tambah
                                        Pengembalian</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Denda</th>
                                        <th>Peminjaman</th>
                                        <th>Anggota</th>
                                        <th>Petugas</th>
                                        <th>Buku</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengembalian as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->tanggal_pengembalian }}</td>
                                            <td>{{ $item->denda}}</td>
                                            <td>{{ $item->peminjaman->tanggal_pinjam }}</td>
                                            <td>{{ $item->anggota->nama }}</td>
                                            <td>{{ $item->petugas->nama }}</td>
                                            <td>
                                                @foreach ($item->pengembalian_detail as $detail)
                                                    {{ $detail->buku->buku }}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('pengembalian.edit', $item->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('pengembalian.destroy', $item->id) }}" method="POST"
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
