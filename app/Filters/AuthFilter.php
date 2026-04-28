<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * @param RequestInterface $request
     * @param array|null       $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil path URL saat ini (misal: 'dashboard' atau 'auth/login')
        $path = $request->getUri()->getPath();

        // 1. CEK: Jika user BELUM login
        if (!session()->get('isLoggedIn')) {
            // Jika dia mencoba akses halaman selain login, paksa ke halaman login
            // Gunakan lowercase atau sesuai route kamu ('auth/login' atau 'auth/Login')
            if ($path !== 'auth/login' && $path !== 'auth/Login') {
                return redirect()->to(site_url('auth/login'));
            }
        } 
        // 2. CEK: Jika user SUDAH login
        else {
            // Jika dia sudah login tapi iseng buka halaman login lagi, lempar ke dashboard
            if ($path === 'auth/login' || $path === 'auth/Login') {
                return redirect()->to(site_url('dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}