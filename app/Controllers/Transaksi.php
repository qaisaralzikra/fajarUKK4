<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\BukuModel;
use App\Models\Keranjang;

class Transaksi extends BaseController
{
    public function index()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $bukuModel      = new \App\Models\BukuModel();
        $userModel      = new \App\Models\UserModel();

        $data = [
            'title'      => 'Data Peminjaman',
            'transaksi'  => $transaksiModel->getTransaksiLengkap(), // Fungsi join yang kita buat sebelumnya
            'buku'       => $bukuModel->findAll(),
            'users'      => $userModel->where('status', 'user')->findAll()
        ];

        return view('transaksi_view', $data);
    }

    public function simpan()
    {
        $transaksiModel = new TransaksiModel();
        $bukuModel      = new BukuModel();

        // 1. Ambil data dari input form
        $buku_id        = $this->request->getPost('buku_id');
        $user_id        = $this->request->getPost('user_id');
        $jumlah_buku        = $this->request->getPost('jumlah_buku');
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam');

        // 2. Validasi Sederhana
        if (!$buku_id || !$user_id) {
            return redirect()->back()->with('error', 'Semua kolom wajib diisi!');
        }

        // 3. Cek apakah buku tersedia (Opsional)
        $buku = $bukuModel->find($buku_id);
        if ($buku['stok'] <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang kosong!');
        }

        if ($buku['stok'] < $jumlah_buku) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang kosong!');
        }

        // 4. Proses Transaksi (Gunakan Database Transaction agar aman)
        $db = \Config\Database::connect();
        $db->transStart(); // Mulai transaksi DB

        // Simpan ke tabel transaksi
        $transaksiModel->insert([
            'user_id'        => $user_id,
            'book_id'        => $buku_id,
            'jumlah_buku' => $jumlah_buku,
            'tanggal_pinjam' => $tanggal_pinjam,
            'status'         => 'Dipinjam'
        ]);

        // Kurangi stok buku di tabel buku
        $bukuModel->update($buku_id, [
            'stok' => $buku['stok'] - $jumlah_buku
        ]);

        $db->transComplete(); // Selesaikan transaksi DB

        // 5. Cek apakah transaksi DB sukses
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }

        return redirect()->to('/transaksi/admin')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function kembali($id)
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $bukuModel      = new \App\Models\BukuModel();

        // 1. Cari data transaksi
        $transaksi = $transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        // 2. Cek jika buku sudah dikembalikan sebelumnya
        if ($transaksi['status'] === 'Kembali') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 3. Update status transaksi & tanggal kembali
        $transaksiModel->update($id, [
            'status'          => 'Kembali',
            'tanggal_kembali' => date('Y-m-d')
        ]);

        // 4. Tambah kembali stok buku
        $buku = $bukuModel->find($transaksi['book_id']); // Gunakan nama kolom sesuai database (buku_id/book_id)
        if ($buku) {
            $bukuModel->update($transaksi['book_id'], [
                'stok' => $buku['stok'] + $transaksi['jumlah_buku'] // Tambahkan jumlah buku yang dipinjam
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses pengembalian.');
        }

        return redirect()->to('/transaksi/admin')->with('success', 'Buku telah berhasil dikembalikan.');
    }

    public function userTransaksi()
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return redirect()->to('/auth');
        }

        $cartModel = new Keranjang();
        $transaksiModel = new TransaksiModel();
        $bukuModel = new BukuModel();

        // 1. Ambil data keranjang
        $cartItems = $cartModel->where('user_id', $userId)->findAll();

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang Anda masih kosong!');
        }

        // --- VALIDASI STOK SEBELUM TRANSAKSI ---
        foreach ($cartItems as $item) {
            $buku = $bukuModel->find($item['book_id']);
            if (!$buku || $buku['stok'] < $item['jumlah']) {
                return redirect()->back()->with('error', 'Gagal! Stok buku "' . ($buku['title'] ?? 'Unknown') . '" tidak mencukupi.');
            }
        }

        // Mulai Database Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $tanggalPinjam = date('Y-m-d');
        $tanggalKembali = date('Y-m-d', strtotime('+7 days'));

        foreach ($cartItems as $item) {
            // 2. Masukkan ke tabel Transaksi
            // Catatan: Jika di tabel transaksi ada kolom 'jumlah', gunakan satu kali insert saja:
            $transaksiModel->insert([
                'user_id'         => $userId,
                'book_id'         => $item['book_id'],
                'tanggal_pinjam'  => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali, // Jangan lupa tanggal kembali
                'status'          => 'Dipinjam',
                'jumlah_buku'          => $item['jumlah'], // Menambahkan jumlah data
                'created_at'      => date('Y-m-d H:i:s'),
            ]);

            // 3. Kurangi stok buku
            $buku = $bukuModel->find($item['book_id']);
            $bukuModel->update($item['book_id'], [
                'stok' => $buku['stok'] - $item['jumlah']
            ]);
        }

        // 4. Hapus keranjang user
        $cartModel->where('user_id', $userId)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat memproses transaksi.');
        }

        return redirect()->to('/user/dashboard')->with('success', 'Transaksi Berhasil!');
    }
}
