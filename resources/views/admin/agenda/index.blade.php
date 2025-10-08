          @extends('admin.layout.master')
          @section('tittle', 'Agenda')

          @section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
            @endsection

            @section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Agenda</h3>
                <p class="text-subtitle text-muted">Daftar Agenda Yang Telah Dibuat</p>
            </div>
            {{-- <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{route('agenda.create')}}" class="btn btn-primary float-start float-lg-end">
                <i class="bi bi-plus"></i>
                Tambah Agenda
                </a>
            </div> --}}
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Agenda</th>
                            <th>Pejabat</th>
                            <th>Agenda</th>
                            <th>Tempat</th>
                            {{-- <th>Pakain</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                          <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)
                                ->locale('id')
                                ->translatedFormat('l, d F Y') }}
                            {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB
                        </td>
                            <td>{{ $item->jabatan->jabatan}}</td>
                            <td>{{ $item->agenda }}</td>
                            <td>{{ $item->tempat }}</td>
                            {{-- <td>{{ $item->pakaian->pakaian }}</td> --}}
                            <td>
                                <a href="{{ route('agenda.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('agenda.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection
