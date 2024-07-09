@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tabungan'])
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-30">
                <div class="card mt-30">
                    <div class="card-body">
                        <div class="userDatatable adv-table-table global-shadow border-0 bg-white w-100 adv-table">
                            <div class="table-responsive">
                                <div class="adv-table-table__header">
                                    <h4>Daftar Tabungan</h4>
                                    <div class="adv-table-table__button">
                                        <div class="">
                                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tabunganModal" style="float: right">Tambah Tabungan</a>
                                        </div>
                                        <div class="filter-container" style="float: right; margin-right: 10px;">
                                            <select id="statusFilter" class="form-select">
                                                <option value="all">Semua</option>
                                                <option value="beres">Beres Cuyy</option>
                                                <option value="belum">Belum Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="filter-form-container"></div>
                                <table class="table mb-0 table-borderless adv-table" data-sorting="true"
                                    data-filter-container="#filter-form-container" data-paging-current="1"
                                    data-paging-position="right" data-paging-size="10">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">No</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Foto Barang</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Nama Barang</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Harga Barang</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Nominal Tabungan Saat Ini</span>
                                            </th>
                                            <th data-type="html" data-name='status'>
                                                <span class="userDatatable-title">status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title float-right">action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($tabungan as $item)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">{{$no++}}</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    <img src="{{asset('/images/tabungan/'.$item->foto)}}" style="max-height: 100px; max-width: 200px;">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{$item->nama_barang}}</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{$item->jumlah_tabungan}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{$item->nominal}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content d-inline-block">
                                                    @php
                                                        $item->status = $item->jumlah_tabungan <= $item->nominal ? 1 : 0;
                                                    @endphp
                                                    @if ($item->status)
                                                    <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active">Beres Cuyy</span>
                                                    @else
                                                    <span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status deactive">Belum Selesai</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('tabungan.destroy', $item->id) }}" id="delete-data" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-button" data-id="{{ $item->id }}" data-nama="{{ $item->nama_barang }}" data-harga="{{ $item->jumlah_tabungan }}" data-nominal="{{ $item->nominal }}" data-foto="{{ asset('/images/tabungan/'.$item->foto) }}" data-bs-toggle="modal" data-bs-target="#editTabunganModal">
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</button>
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
        </div>
    </div>
    {{-- data modal --}}
    <form action="{{ route('tabungan.store',app()->getLocale()) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="tabunganModal" tabindex="-1" aria-labelledby="tabunganModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tabunganModalLabel">Tabungan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga Barang</label>
                            <input type="number" name="jumlah_tabungan" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Masukan Nominal</label>
                            <input type="number" name="nominal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Masukan Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- end modal --}}
    {{-- start edit modal --}}
    <form action="" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editTabunganModal" tabindex="-1" aria-labelledby="editTabunganModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editTabunganModalLabel">Edit Tabungan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-nama-barang">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="edit-nama-barang">
                        </div>
                        <div class="mb-3">
                            <label for="edit-harga-barang">Harga Barang</label>
                            <input type="number" name="jumlah_tabungan" class="form-control" id="edit-harga-barang">
                        </div>
                        <div class="mb-3">
                            <label for="edit-nominal">Masukan Nominal</label>
                            <input type="number" name="nominal" class="form-control" id="edit-nominal">
                        </div>
                        <div class="mb-3">
                            <label for="edit-foto">Masukan Foto</label>
                            <input type="file" name="foto" class="form-control" id="edit-foto">
                            <img id="edit-foto-preview" src="" style="max-height: 100px; max-width: 200px; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- end edit modal --}}
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('tbody tr');

    statusFilter.addEventListener('change', function() {
        const filterValue = this.value;
        tableRows.forEach(row => {
            const statusCell = row.querySelector('td:nth-child(6) .userDatatable-content-status');
            if (statusCell) {
                const statusText = statusCell.textContent.trim();
                if (filterValue === 'all') {
                    row.style.display = '';
                } else if (filterValue === 'beres' && statusText === 'Beres Cuyy') {
                    row.style.display = '';
                } else if (filterValue === 'belum' && statusText === 'Belum Selesai') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    const editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const harga = this.getAttribute('data-harga');
            const nominal = this.getAttribute('data-nominal');
            const foto = this.getAttribute('data-foto');

            document.getElementById('edit-nama-barang').value = nama;
            document.getElementById('edit-harga-barang').value = harga;
            document.getElementById('edit-nominal').value = nominal;
            document.getElementById('edit-foto-preview').src = foto;

            const form = document.getElementById('editForm');
            form.action = '/tabungan/' + id; // Update this URL to match your route
        });
    });
});
</script>
