<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Library extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();
        $data = [
            'title' => 'Koleksi Buku',
            'username' => session()->get('username'),
            'books' => $model->findAll()
        ];

        return view('library_view', $data);
    }

    public function user()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();
        $data = [
            'title' => 'Koleksi Buku',
            'username' => session()->get('username'),
            'books' => $model->findAll()
        ];

        return view('users/library', $data);
    }

    public function userBookDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();

        // 1. Ambil satu baris data saja berdasarkan ID
        $buku = $model->find($id);

        // 2. Cek apakah buku ditemukan
        if (!$buku) {
            return redirect()->to('/users/dashboard')->with('error', 'Buku tidak ditemukan.');
        }

        // 3. Susun data dengan benar
        $data = [
            'title' => 'Detail Buku - ' . $buku['title'],
            'buku'  => $buku // Menggunakan nama variabel tunggal agar lebih masuk akal (bukan 'books')
        ];

        return view('users/detail_buku', $data);
    }

    public function bookDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();

        // 1. Ambil satu baris data saja berdasarkan ID
        $buku = $model->find($id);

        // 2. Cek apakah buku ditemukan
        if (!$buku) {
            return redirect()->to('/dashboard')->with('error', 'Buku tidak ditemukan.');
        }

        // 3. Susun data dengan benar
        $data = [
            'title' => 'Detail Buku - ' . $buku['title'],
            'buku'  => $buku // Menggunakan nama variabel tunggal agar lebih masuk akal (bukan 'books')
        ];

        return view('detail_buku', $data);
    }

    public function save()
    {
        $model = new BukuModel();

        // 1. Ambil file dari input form (name="cover")
        $fileCover = $this->request->getFile('cover');

        // 2. Cek apakah ada file yang diunggah
        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            // Berikan nama random agar tidak ada file dengan nama yang sama
            $namaCover = $fileCover->getRandomName();

            // Pindahkan file ke folder public/uploads/covers
            $fileCover->move('uploads/covers', $namaCover);
        } else {
            // Jika tidak ada file, set nama default
            $namaCover = 'default.jpg';
        }

        // 3. Simpan ke database termasuk kolom 'cover'
        $model->save([
            'title'  => $this->request->getPost('title'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'stok'  => $this->request->getPost('stok'),
            'tanggal_terbit'  => $this->request->getPost('terbit'),
            'author' => $this->request->getPost('author'),
            'cover'  => $namaCover, // Simpan nama filenya di sini
            'status' => 'Tersedia'
        ]);

        return redirect()->to('/library');
    }

    public function delete($id)
    {
        $model = new BukuModel();
        $model->delete($id);
        return redirect()->to('/library');
    }
}
