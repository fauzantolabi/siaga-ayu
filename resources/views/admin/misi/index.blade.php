          @extends('admin.layout.master-navbar')
          @section('tittle', 'Misi')

          @section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
            @endsection

            @section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Misi</h3>
                <p class="text-subtitle text-muted">Daftar Misi Yang Telah Ditambahkan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{route('misi.create')}}" class="btn btn-primary float-start float-lg-end">
                <i class="bi bi-plus"></i>
                Tambah Misi
                </a>
            </div>
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
                <th>Misi</th>
                <th>Deskripsi</th>
                <th>Jumlah Program</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($misis as $misi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $misi->misi }}</td>
                <td>{{ $misi->description }}</td>
                <td>{{ $misi->programs_count }}</td>
                <td>
                    <a href="{{ route('misi.edit', $misi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('misi.destroy', $misi->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus misi ini?')">Hapus</button>
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

@section('scripts')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('table1')) {
      let dataTable = new simpleDatatables.DataTable(
        document.getElementById('table1'),
        {
          searchable: true,
          paging: true,
          perPage: 10,
          perPageSelect: [5, 10, 15, 20],
          sortable: true,
          layout: {
            top: "{select}{search}",
            bottom: "{info}{pager}",
          },
        }
      );

      function adaptPageDropdown() {
        const selector = dataTable.wrapper.querySelector(".dataTable-selector");
        if (selector) {
          selector.parentNode.parentNode.insertBefore(selector, selector.parentNode);
          selector.classList.add("form-select");
        }
      }

      function adaptPagination() {
        const paginations = dataTable.wrapper.querySelectorAll("ul.dataTable-pagination-list");
        for (const pagination of paginations) {
          pagination.classList.add(...["pagination", "pagination-primary"]);
        }

        const paginationLis = dataTable.wrapper.querySelectorAll("ul.dataTable-pagination-list li");
        for (const paginationLi of paginationLis) {
          paginationLi.classList.add("page-item");
        }

        const paginationLinks = dataTable.wrapper.querySelectorAll("ul.dataTable-pagination-list li a");
        for (const paginationLink of paginationLinks) {
          paginationLink.classList.add("page-link");
        }
      }

      dataTable.on("datatable.init", () => {
        adaptPageDropdown();
        adaptPagination();
      });

      dataTable.on("datatable.update", () => adaptPagination());
      dataTable.on("datatable.sort", () => adaptPagination());
      dataTable.on("datatable.page", () => adaptPagination());
    }
  });
</script>
@endsection
