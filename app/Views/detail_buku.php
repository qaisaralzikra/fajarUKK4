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
            <a class="nav-link" href="<?= base_url('dashboard'); ?>"><i class="fas fa-tachometer-alt me-2"></i><span>Dashboard</span></a>
            <a class="nav-link active" href="<?= base_url('library'); ?>"><i class="fas fa-book me-2"></i><span>Daftar Buku</span></a>
            <a class="nav-link" href="<?= base_url('transaksi/admin'); ?>"><i class="fas fa-users me-2"></i><span>Transaksi</span></a>
            <a class="nav-link" href="<?= base_url('profil/admin'); ?>"><i class="fas fa-user me-2"></i><span>Profil</span></a>
            <div class="mt-5 p-3">
                <a href="<?= base_url('auth/logout'); ?>" class="btn btn-light btn-sm w-100 fw-bold text-danger">
                    <i class="fas fa-sign-out-alt me-1"></i><span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex flex-column mb-4">
            <h2 class="h3 mb-0 text-gray-800"><?= $title ?></h2>
        </div>

        <div class="card p-4 flex flex-row w-100 gap-4">
            <div>
                <img src="<?= base_url('uploads/covers/' . ($buku['cover'] ?: 'default.jpg')); ?>" class="book-cover-table" style="width: 200px; height: 260px;" alt="cover">
            </div>
            <div style="width: 700px;">
                <h6 class="text-[14px]"><strong>Judul Buku:</strong> <?= $buku['title'] ?></h6>
                <p><strong>Tanggal Terbit:</strong> <?= $buku['tanggal_terbit'] ?></p>
                <p><strong>Pengarang:</strong> <?= $buku['author'] ?></p>
                <p><strong>Jumlah Stok:</strong> <?= $buku['stok'] ?></p>
                <p><strong>Deskripsi:</strong> <?= $buku['deskripsi'] ?></p>
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