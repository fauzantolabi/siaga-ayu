          @extends('admin.layout.master-navbar')
          @section('tittle', 'Role')

          @section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
            @endsection

            @section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Role</h3>
                <p class="text-subtitle text-muted">Daftar Role Yang Telah Ditambahkan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{route('role.create')}}" class="btn btn-primary float-start float-lg-end">
                <i class="bi bi-plus"></i>
                Tambah Role
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
                            <th>Role</th>
                            <th>Singkatan Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->role_name }}</td>
                            <td>{{ $item->description}}</td>
                            <td>
                                <a href="{{ route('role.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('role.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
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
