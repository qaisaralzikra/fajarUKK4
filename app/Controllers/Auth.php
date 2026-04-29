<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('login_view'); // Tampilkan halaman login
    }

    public function registrasi()
    {
        return view('registrasi'); // Tampilkan halaman login
    }

    public function registrasiAdmin()
    {
        return view('registrasi_admin'); // Tampilkan halaman login
    }

    public function profilAdmin()
    {
        $session = session();

        $model = new UserModel();

        $foto = $model->where('id', $session->get('id'))->first();

        $data = ([
            'username' => $session->get('username'),
            'jabatan' => $session->get('status'),
            'ttl' => $session->get('ttl'),
            'foto' => $foto['foto']
        ]);

        return view('profil_admin', $data); // Tampilkan halaman login
    }

    public function profilUser()
    {
        $session = session();

        $model = new UserModel();

        $foto = $model->where('id', $session->get('id'))->first();

        $data = ([
            'username' => $session->get('username'),
            'jabatan' => $session->get('status'),
            'ttl' => $session->get('ttl'),
            'foto' => $foto['foto']
        ]);

        return view('users/profil_user', $data); // Tampilkan halaman login
    }

    public function createAccount()
    {
        $model = new UserModel();

        // 1. Ambil input dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $ttl = $this->request->getVar('ttl');

        $fileCover = $this->request->getFile('cover');

        // 2. Cek apakah ada file yang diunggah
        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            // Berikan nama random agar tidak ada file dengan nama yang sama
            $namaCover = $fileCover->getRandomName();

            // Pindahkan file ke folder public/foto
            $fileCover->move('foto/user', $namaCover);
        } else {
            // Jika tidak ada file, set nama default
            $namaCover = 'default.jpg';
        }

        // 2. Cek apakah username sudah ada di database
        $userExist = $model->where('username', $username)->first();
        if ($userExist) {
            return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar, silakan gunakan yang lain.');
        }

        // 3. Simpan data dengan password yang sudah di-hash (disamarkan)
        $model->save([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Membuat password tidak kelihatan di DB
            'status'   => 'user', // Default status untuk akun baru
            'foto'  => $namaCover,
            'ttl' => $ttl
        ]);

        return redirect()->to('/auth')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function createAccountAdmin()
    {
        $model = new UserModel();

        // 1. Ambil input dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $ttl = $this->request->getVar('ttl');

        $fileCover = $this->request->getFile('cover');

        // 2. Cek apakah ada file yang diunggah
        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            // Berikan nama random agar tidak ada file dengan nama yang sama
            $namaCover = $fileCover->getRandomName();

            // Pindahkan file ke folder public/foto
            $fileCover->move('foto', $namaCover);
        } else {
            // Jika tidak ada file, set nama default
            $namaCover = 'default.jpg';
        }

        // 2. Cek apakah username sudah ada di database
        $userExist = $model->where('username', $username)->first();
        if ($userExist) {
            return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar, silakan gunakan yang lain.');
        }

        // 3. Simpan data dengan password yang sudah di-hash (disamarkan)
        $model->save([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Membuat password tidak kelihatan di DB
            'status'   => 'admin', // Default status untuk akun baru
            'foto'  => $namaCover,
            'ttl' => $ttl
        ]);

        return redirect()->to('/auth')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();

        $username = trim($this->request->getVar('username'));
        $password = trim($this->request->getVar('password'));

        // 1. Cari user berdasarkan username saja
        $user = $model->where('username', $username)->first();

        // password_verify(input_user, password_di_database)
        if ($user && password_verify($password, $user['password'])) {

            // 3. Set Session Data
            $sessionData = [
                'id'         => $user['id'],
                'username'   => $user['username'],
                'status'     => $user['status'],
                'ttl' => $user['ttl'],
                'isLoggedIn' => true
            ];
            $session->set($sessionData);

            // 4. Redirect berdasarkan status/role
            if ($user['status'] === 'admin') {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            // 5. Jika gagal (username tidak ada atau password salah)
            return redirect()->back()->with('error', 'Login Gagal! Username atau Password salah.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
