<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: white; z-index: 100; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 15px 20px; font-weight: 500; text-decoration: none; display: block; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(255,255,255,0.1); }
        .main-content { margin-left: 260px; padding: 30px; }
        .card-custom { border: none; border-left: 5px solid; border-radius: 10px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .border-primary-custom { border-left-color: #4e73df; }
        .border-success-custom { border-left-color: #1cc88a; }
        .border-warning-custom { border-left-color: #f6c23e; }
        .stat-label { font-size: 0.7rem; font-weight: bold; text-transform: uppercase; }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: #5a5c69; }
        .img-cover-preview { width: 45px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="p-4 text-center">
        <h4 class="fw-bold"><i class="fas fa-book-open me-2"></i><span>Perpustakaan</span></h4>
    </div>
    <nav class="nav flex-column mt-3">
        <a class="nav-link active" href="<?= base_url('dashboard'); ?>"><i class="fas fa-tachometer-alt me-2"></i><span>Dashboard</span></a>
        <a class="nav-link" href="<?= base_url('library'); ?>"><i class="fas fa-book me-2"></i><span>Daftar Buku</span></a>
        <a class="nav-link" href="<?= base_url('transaksi/admin'); ?>"><i class="fas fa-users me-2"></i><span>Peminjam</span></a>
        <a class="nav-link" href="<?= base_url('profil/admin'); ?>"><i class="fas fa-user me-2"></i><span>Profil</span></a>
        <div class="mt-5 p-3">
            <a href="<?= base_url('auth/logout'); ?>" class="btn btn-light btn-sm w-100 fw-bold text-danger">
                <i class="fas fa-sign-out-alt me-1"></i><span>Logout</span>
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Ringkasan Data</h2>
        <span class="badge bg-white shadow-sm text-dark p-2 rounded border">
              Selamat Datang, <strong><?= $username; ?></strong>! 👋
        </span>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom border-primary-custom h-100 py-2 bg-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="stat-label text-primary mb-1">Total Koleksi Buku</div>
                            <div class="stat-value"><?= $total_buku; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-layer-group fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom border-success-custom h-100 py-2 bg-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="stat-label text-success mb-1">Anggota Aktif</div>
                            <div class="stat-value"><?= $total_member; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-custom border-warning-custom h-100 py-2 bg-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="stat-label text-warning mb-1">Sedang Dipinjam</div>
                            <div class="stat-value"><?= $buku_dipinjam; ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-history fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Buku Terbaru <?= $total_buku; ?></h6>
                    <a href="<?= base_url('library'); ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="100">Cover</th>
                                    <th>Judul & Pengarang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($latest_books)) : ?>
                                    <?php foreach ($latest_books as $b) : ?>
                                    <tr>
                                        <td class="ps-3">
                                            <img src="<?= base_url('uploads/covers/' . ($b['cover'] ?: 'default.jpg')); ?>" 
                                                 class="img-cover-preview shadow-sm" 
                                                 alt="cover">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $b['title']; ?></div>
                                            <div class="small text-muted"><?= $b['author']; ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $b['status'] == 'Tersedia' ? 'bg-success' : 'bg-warning'; ?>">
                                                <?= $b['status']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center p-4 text-muted">Belum ada data buku.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 p-4 border-0">
                <h5 class="fw-bold"><i class="fas fa-info-circle text-info me-2"></i>Bantuan</h5>
                <hr>
                <p class="text-muted small">
                    Halo <strong><?= $username; ?></strong>, pastikan setiap buku memiliki <strong>Cover</strong> agar katalog terlihat menarik bagi pengunjung.
                </p>
                <div class="d-grid mt-3">
                    <a href="<?= base_url('library'); ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="fas fa-plus me-1"></i> Tambah Buku Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>