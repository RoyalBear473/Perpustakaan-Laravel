@extends('layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rak Buku</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Rak Buku</h3>
                            <div class="card-tools">
                                <a href="{{ route('rak.create') }}" class="btn btn-primary mb-3">
                                    Tambah Rak
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Kode Rak</th>
                                        <th style="width: 30%;">Lokasi</th>
                                        <th style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rak as $item)
                                        <tr>
                                            <td>{{ $item->kode_rak }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>
                                                <a href="{{ route('rak.edit', $item->kode_rak) }}" class="btn btn-warning">
                                                    Edit
                                                </a>
                                                <form action="{{ route('rak.destroy', $item->kode_rak) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
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
        </div>
    </section>
@endsection
