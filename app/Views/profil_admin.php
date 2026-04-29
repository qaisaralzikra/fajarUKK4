<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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

        .profile-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            padding: 30px;
            width: 500px;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .profile-photo {
            width: 150px;
            height: 180px;
            background-color: #e9ecef;
            border: 2px dashed #adb5bd;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #6c757d;
            font-weight: bold;
            margin-right: 30px;
            flex-shrink: 0;
        }

        .profile-info {
            flex-grow: 1;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 18px;
            color: #333;
            font-weight: 600;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
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
            <a class="nav-link" href="<?= base_url('transaksi/admin'); ?>"><i class="fas fa-users me-2"></i><span>Peminjam</span></a>
            <a class="nav-link active" href="<?= base_url('profil/admin'); ?>"><i class="fas fa-user me-2"></i><span>Profil</span></a>
            <div class="mt-5 p-3">
                <a href="<?= base_url('auth/logout'); ?>" class="btn btn-light btn-sm w-100 fw-bold text-danger">
                    <i class="fas fa-sign-out-alt me-1"></i><span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="profile-card">
            <div class="profile-photo relative">
                <img src="<?= base_url('foto/' . ($foto ?: 'default.jpg')); ?>" class="book-cover-table w-[300px] h-[200px] absolute" alt="cover">
            </div>

            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <div class="info-value"><?= $username ?></div>
                </div>

                <div class="info-row">
                    <span class="info-label">Jabatan</span>
                    <div class="info-value"><?= $jabatan ?></div>
                </div>

                <div class="info-row">
                    <span class="info-label">TTL</span>
                    <div class="info-value"><?= $ttl ?></div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>