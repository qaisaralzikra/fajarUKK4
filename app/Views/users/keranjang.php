<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Style tambahan untuk cover */
        .book-cover-table {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .img-preview {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border-radius: 5px;
            display: none;
            margin-top: 10px;
            border: 2px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold"><i class="fas fa-book-open me-2"></i><span>Perpustakaan</span></h4>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link" href="<?= base_url('user/dashboard'); ?>"><i class="fas fa-tachometer-alt me-2"></i><span>Dashboard</span></a>
            <a class="nav-link" href="<?= base_url('user/library'); ?>"><i class="fas fa-book me-2"></i><span>Daftar Buku</span></a>
            <a class="nav-link active" href="<?= base_url('user/keranjang'); ?>"><i class="fas fa-users me-2"></i><span>Keranjang</span></a>
            <div class="mt-5 p-3">
                <a href="<?= base_url('auth/logout'); ?>" class="btn btn-light btn-sm w-100 fw-bold text-danger">
                    <i class="fas fa-sign-out-alt me-1"></i><span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Keranjang Saya</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Buku</th>
                                            <th></th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($cartItems)) : ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4">Keranjang Anda kosong.</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($cartItems as $item) : ?>
                                                <tr>
                                                    <td style="width: 100px;">
                                                        <img src="<?= base_url('uploads/covers/' . ($item['cover'] ?: 'default.jpg')); ?>"
                                                            class="img-fluid rounded shadow-sm" alt="cover">
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0"><?= $item['title']; ?></h6>
                                                        <small class="text-muted">Stok tersedia: <?= $item['stok']; ?></small>
                                                    </td>
                                                    <td style="width: 150px;">
                                                        <div class="input-group input-group-sm">
                                                            <p><?= $item['jumlah'] ?> Buku</p>
                                                        </div>
                                                    </td>
                                                    <td>

                                                        <button
                                                            type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['cart_id']; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                        <div class="modal fade" id="deleteModal<?= $item['cart_id']; ?>" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="<?= base_url('cart/delete/' . $item['cart_id']); ?>" method="post">
                                                                        <?= csrf_field(); ?>
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus buku <strong><?= $item['title']; ?></strong> dari keranjang?</p>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit" class="btn btn-danger">Hapus Data</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-primary">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ringkasan Pinjaman</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Buku:</span>
                                <strong><?= $total_item ?> Buku</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span>Durasi Peminjaman:</span>
                                <strong>7 Hari</strong>
                            </div>
                            <hr>
                            <button class="btn btn-primary w-100 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#transaksiModal">
                                Lanjutkan Transaksi <i class="fas fa-arrow-right ms-2"></i>
                            </button>

                            <div class="modal fade" id="transaksiModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('user/transaksi'); ?>" method="post">
                                            <?= csrf_field(); ?>

                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin memproses <strong><?= $total_item; ?> buku</strong> untuk dipinjam?</p>
                                                <ul class="text-muted small">
                                                    <li>Batas waktu pengembalian adalah 7 hari dari sekarang.</li>
                                                    <li>Pastikan data buku sudah sesuai.</li>
                                                </ul>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Ya, Pinjam Sekarang</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="/user/library" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">
                                <i class="fas fa-plus me-1"></i> Tambah Buku Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk preview gambar saat dipilih
        function previewImg() {
            const input = document.querySelector('#coverInput');
            const preview = document.querySelector('#imgPreview');

            preview.style.display = 'block';

            const fileReader = new FileReader();
            fileReader.readAsDataURL(input.files[0]);

            fileReader.onload = function(e) {
                preview.src = e.target.result;
            }
        }
    </script>
</body>

</html>