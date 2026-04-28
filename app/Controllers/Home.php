<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new BukuModel();
        
        // Mengambil semua data buku dari database
        $data['semuabuku'] = $model->findAll();

        // Mengirim data ke file view bernama 'daftar_buku'
        return view('daftar_buku', $data);
    }
}