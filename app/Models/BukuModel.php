<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table      = 'books'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'author', 'status', 'cover', 'stok', 'deskripsi', 'tanggal_terbit'];
}