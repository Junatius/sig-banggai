@extends('layout.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
@endsection
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
              <li class="breadcrumb-item active">Data Objek Wisata (Server Side)</li>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="serverside">
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

@section('scripts')
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>

    <script>
        $(document).ready( function () {
            loadData();
        } );

        function loadData(){
          $('#serverside').DataTable({
            processing:true,
            pagination:true,
            responsive:false,
            serverSide:true,
            searching:true,
            ordering:false,
            ajax:{
              url:"{{ route('admin.serverside') }}",
            },
            columns:[
              {
                data : 'no',
                name : 'no',
              },
              {
                data : 'gambar',
                name : 'gambar',
              },
              {
                data : 'nama',
                name : 'nama',
              },
              {
                data : 'kategori',
                name : 'kategori',
              },
              {
                data : 'jam_buka',
                name : 'jam_buka',
              },
              {
                data : 'htm',
                name : 'htm',
              },
              {
                data : 'kecamatan',
                name : 'kecamatan',
              },
              {
                data : 'action',
                name : 'action',
              },
            ],
          });
        }
    </script>
@endsection