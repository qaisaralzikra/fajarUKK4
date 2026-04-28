<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Peminjaman</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            font-weight: 500;
            text-decoration: none;
            display: block;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .card-custom {
            border: none;
            border-left: 5px solid;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .border-primary-custom {
            border-left-color: #4e73df;
        }

        .border-success-custom {
            border-left-color: #1cc88a;
        }

        .border-warning-custom {
            border-left-color: #f6c23e;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #5a5c69;
        }

        .img-cover-preview {
            width: 45px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold"><i class="fas fa-book-open me-2"></i><span>Perpustakaan</span></h4>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link" href="<?= base_url('dashboard'); ?>"><i class="fas fa-tachometer-alt me-2"></i><span>Dashboard</span></a>
            <a class="nav-link" href="<?= base_url('library'); ?>"><i class="fas fa-book me-2"></i><span>Daftar Buku</span></a>
            <a class="nav-link active" href="<?= base_url('transaksi/admin'); ?>"><i class="fas fa-users me-2"></i><span>Peminjam</span></a>
            <div class="mt-5 p-3">
                <a href="<?= base_url('auth/logout'); ?>" class="btn btn-light btn-sm w-100 fw-bold text-danger">
                    <i class="fas fa-sign-out-alt me-1"></i><span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4><?= $title; ?></h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Tambah Pinjaman
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Pengembalian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $t['username']; ?></td>
                                    <td><?= $t['title']; ?></td>
                                    <td><?= $t['jumlah_buku']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal_pinjam'])); ?></td>
                                    <td><?= $t['tanggal_kembali'] ? date('d/m/Y', strtotime($t['tanggal_kembali'])) : '-'; ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($t['status'] == 'Dipinjam') ? 'warning' : 'success'; ?>">
                                            <?= $t['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($t['status'] == 'Dipinjam') : ?>
                                            <a href="/transaksi/kembali/<?= $t['id']; ?>" class="btn btn-sm btn-outline-primary">Kembalikan</a>
                                        <?php else : ?>
                                            <span class="text-muted small">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Peminjaman Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('transaksi/simpan'); ?>" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Pilih Member</label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Pilih Nama --</option>
                                    <?php foreach ($users as $u): ?>
                                        <option value="<?= $u['id']; ?>"><?= $u['username']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilih Buku</label>
                                <select name="buku_id" class="form-select" required>
                                    <option value="">-- Pilih Judul --</option>
                                    <?php foreach ($buku as $b): ?>
                                        <option value="<?= $b['id']; ?>"><?= $b['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Buku</label>
                                <input type="number" name="jumlah_buku" class="form-control"required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>