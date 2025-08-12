@extends('layout.main')
@section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Objek Wisata</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Objek Wisata</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <a href="{{ route('admin.objek-wisata.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                  <form action="{{ route('admin.objek-wisata.index') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $request->get('search') }}">
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Gambar</th>
                      <th>Nama</th>
                      <th>Kategori</th>
                      <th>Jam Buka</th>
                      <th>HTM</th>
                      <th>Kecamatan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @foreach($objekWisata as $wisata)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('storage/wisata/'.$wisata->gambar) }}" width="100"></td>
                        <td>{{ $wisata->nama }}</td>
                        <td>{{ $wisata->kategori }}</td>
                        <td>{{ $wisata->jam_buka }}</td>
                        <td>{{ $wisata->htm }}</td>
                        <td>{{ $wisata->kecamatan }}</td>
                        <td>
                            <a href="{{ route('admin.objek-wisata.edit',['id' => $wisata->id]) }}" class="btn btn-primary">
                                <i class="fas fa-pen"></i> Edit
                            </a>

                            <!-- Tombol untuk memunculkan modal hapus -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-hapus{{ $wisata->id }}">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="modal-hapus{{ $wisata->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah kamu yakin ingin menghapus objek wisata <b>{{ $wisata->nama }}</b>?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <form action="{{ route('admin.objek-wisata.delete', ['id' => $wisata->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection