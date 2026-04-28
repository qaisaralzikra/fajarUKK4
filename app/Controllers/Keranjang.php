<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModel;
use App\Models\Keranjang as ModelsKeranjang;
use CodeIgniter\HTTP\ResponseInterface;

class Keranjang extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $cartModel = new \App\Models\Keranjang();
        $userId = session()->get('id');

        $items = $cartModel->select('cart.id as cart_id, cart.jumlah, books.*')
            ->join('books', 'books.id = cart.book_id')
            ->where('cart.user_id', $userId)
            ->findAll();

        // MENGHITUNG SEMUA JUMLAH
        // array_column mengambil semua angka di kolom 'jumlah'
        // array_sum menjumlahkan angka-angka tersebut
        $total_item = array_sum(array_column($items, 'jumlah'));

        $data = [
            'title'      => 'Keranjang Belanja',
            'cartItems'  => $items,
            'username'   => session()->get('username'),
            'total_data' => count($items), // Menghitung ada berapa jenis buku
            'total_item' => $total_item    // Menghitung total seluruh buku yang dipesan
        ];

        return view('users/keranjang', $data);
    }

    public function create($id)
    {
        $model = new ModelsKeranjang;

        $model->save([
            'user_id' => session()->get('id'),
            'book_id' => $id,
            'jumlah' => $this->request->getPost('jumlah_buku'),
            'created_at' => date('Y-m-d')
        ]);

        return redirect()->to('/user/keranjang');
    }

    public function delete($id) {
        $model = new \App\Models\Keranjang();
        $model->delete($id);
        return redirect()->to('/user/keranjang');
    }
}
