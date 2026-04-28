<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();
        $user = new UserModel();
        $transaksi = new TransaksiModel();

        $users = $user->where('status', 'user')->findAll();

        // Mengambil data untuk statistik di card
        $data = [
            'title'         => 'Dashboard Perpustakaan',
            'username'      => session()->get('username'),
            'total_buku'    => $model->countAll(),
            'total_member'  => count($users), // Contoh statis, bisa ganti dengan countAll dari MemberModel
            'buku_dipinjam' => $transaksi->where('status', 'Dipinjam')->countAllResults(),

            // Mengambil 5 buku yang paling baru ditambahkan
            'latest_books'  => $model->orderBy('id', 'DESC')->findAll(5)
        ];

        return view('dashboard_view', $data);
    }

    public function user()
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $model = new BukuModel();
        $user = new UserModel();
        $transaksi = new TransaksiModel();
        $userId = session()->get('id');

        // Mengambil data untuk statistik di card
        $data = [
            'title'         => 'Dashboard Perpustakaan',
            'username'      => session()->get('username'),
            'jumlah_transaksi'    => $transaksi->where('user_id', $userId)->countAllResults(),
            'buku_dipinjam'    => $transaksi->where('user_id', $userId)
                ->where('status', 'Dipinjam')
                ->countAllResults(),
            'jumlah_buku_tersedia' => $model->where('status', 'tersedia')->countAllResults(),

            // Mengambil 5 buku yang paling baru ditambahkan
            'latest_books'  => $model->where('status', 'tersedia')->orderBy('id', 'DESC')->findAll(5)
        ];

        return view('users/dashboard', $data);
    }
}
