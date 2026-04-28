<?php
// Simulasi data dari database
$semuabuku = [
    [
        'title' => 'Laskar Pelangi',
        'author' => 'Andrea Hirata',
        'status' => 'Tersedia'
    ],
    [
        'title' => 'Bumi',
        'author' => 'Tere Liye',
        'status' => 'Dipinjam'
    ],
    [
        'title' => 'Filosofi Teras',
        'author' => 'Henry Manampiring',
        'status' => 'Tersedia'
    ],
    [
        'title' => 'Atomic Habits',
        'author' => 'James Clear',
        'status' => 'Tersedia'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pinjam Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container-box { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="p-5">

    <div class="container container-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Katalog Buku Perpustakaan</h1>
            <button class="btn btn-primary">+ Tambah Buku</button>
        </div>

        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($semuabuku as $b) : ?>
                <tr>
                    <td class="fw-bold"><?= $b['title']; ?></td>
                    <td><?= $b['author']; ?></td>
                    <td>
                        <?php if($b['status'] == 'Tersedia') : ?>
                            <span class="badge bg-success">Tersedia</span>
                        <?php else : ?>
                            <span class="badge bg-danger">Dipinjam</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="#" class="btn btn-info text-white">Detail</a>
                            <?php if($b['status'] == 'Tersedia') : ?>
                                <a href="#" class="btn btn-success">Pinjam</a>
                            <?php endif; ?>
                            <a href="#" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>