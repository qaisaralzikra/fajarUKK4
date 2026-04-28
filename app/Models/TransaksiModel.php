<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'book_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'jumlah_buku'];

    // Aktifkan fitur otomatis mencatat waktu
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Fungsi custom untuk mengambil data transaksi beserta nama user dan title books
     */
    public function getTransaksiLengkap()
    {
       return $this->select('transaksi.*, users.username, books.title')
            ->join('users', 'users.id = transaksi.user_id')
            ->join('books', 'books.id = transaksi.book_id')
            // Logika: Jika status 'Dipinjam' beri nilai 1, selain itu 2. Lalu urutkan dari terkecil.
            ->orderBy("CASE 
                WHEN transaksi.status = 'Dipinjam' THEN 1 
                WHEN transaksi.status = 'Kembali' THEN 2
                ELSE 3 END", 'ASC')
            ->orderBy('transaksi.created_at', 'DESC') // Urutan kedua: yang terbaru
            ->findAll();
    }
}