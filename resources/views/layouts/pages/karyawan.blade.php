@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="float-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">
                Tambah Karyawan
            </button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nomor Induk</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Tanggal Bergabung</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $k)
                    <tr>
                        <td>{{ $k->nomor_induk }}</td>
                        <td>{{ $k->nama }}</td>
                        <td>{{ $k->alamat }}</td>
                        <td>{{ $k->tanggal_lahir }}</td>
                        <td>{{ $k->tanggal_bergabung }}</td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#showModal"
                                data-id="{{ $k->id }}">Lihat</button>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $k->id }}">Edit</button>
                            <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Show Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detail Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Detail Content will be loaded here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Karyawan -->
    <div class="modal fade" id="addKaryawanModal" tabindex="-1" aria-labelledby="addKaryawanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKaryawanModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('karyawan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                            <input type="date" class="form-control" id="tanggal_bergabung" name="tanggal_bergabung"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editNomorInduk" class="form-label">Nomor Induk</label>
                            <input type="text" class="form-control" id="editNomorInduk" name="nomor_induk" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="editTanggalLahir" name="tanggal_lahir"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggalBergabung" class="form-label">Tanggal Bergabung</label>
                            <input type="date" class="form-control" id="editTanggalBergabung"
                                name="tanggal_bergabung" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addKaryawanForm = document.getElementById('addKaryawanForm');
            const addKaryawanModal = new bootstrap.Modal(document.getElementById('addKaryawanModal'));

            addKaryawanForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('{{ route('karyawan.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                            addKaryawanModal.hide();
                            addKaryawanForm.reset();
                        } else {
                            alert('Gagal menambahkan karyawan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan.');
                    });
            });
            const showModal = document.getElementById('showModal');
            const editModal = document.getElementById('editModal');

            showModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');

                fetch(`/karyawan/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        showModal.querySelector('.modal-body').innerHTML = `
                    <p><strong>Nomor Induk:</strong> ${data.nomor_induk}</p>
                    <p><strong>Nama:</strong> ${data.nama}</p>
                    <p><strong>Alamat:</strong> ${data.alamat}</p>
                    <p><strong>Tanggal Lahir:</strong> ${data.tanggal_lahir}</p>
                    <p><strong>Tanggal Bergabung:</strong> ${data.tanggal_bergabung}</p>
                `;
                    });
            });

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');

                fetch(`/karyawan/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const form = editModal.querySelector('#editForm');
                        form.action = `/karyawan/${id}`;
                        form.querySelector('#editNomorInduk').value = data.nomor_induk;
                        form.querySelector('#editNama').value = data.nama;
                        form.querySelector('#editAlamat').value = data.alamat;
                        form.querySelector('#editTanggalLahir').value = data.tanggal_lahir;
                        form.querySelector('#editTanggalBergabung').value = data.tanggal_bergabung;
                    });
            });
        });
    </script>
@endsection
