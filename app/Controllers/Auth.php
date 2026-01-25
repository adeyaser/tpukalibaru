<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['acl', 'form', 'url']);
    }

    /**
     * Login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login
     */
    public function attemptLogin()
    {
        $rules = [
            'login' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username dan password wajib diisi');
        }

        // Verify Turnstile
        $turnstileSecret = env('TURNSTILE_SECRET_KEY');
        if ($turnstileSecret) {
            $turnstileResponse = $this->request->getPost('cf-turnstile-response');
            if (!$turnstileResponse) {
                return redirect()->back()->withInput()->with('error', 'Silakan selesaikan captcha Turnstile');
            }

            $client = \Config\Services::curlrequest();
            $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => [
                    'secret' => $turnstileSecret,
                    'response' => $turnstileResponse,
                    'remoteip' => $this->request->getIPAddress(),
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            if (!$result['success']) {
                return redirect()->back()->withInput()->with('error', 'Verifikasi Turnstile gagal, silakan coba lagi');
            }
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // Find user by username or email
        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau email tidak ditemukan');
        }

        // Check if user is active
        if ($user['status'] !== 'active') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah');
        }

        // Get user with groups
        $userData = $this->userModel->getUserWithGroups($user['id']);

        // Set session data
        $sessionData = [
            'userId' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'namaLengkap' => $user['nama_lengkap'],
            'foto' => $user['foto'],
            'groups' => $userData['groups'],
            'isLoggedIn' => true,
        ];

        session()->set($sessionData);

        // Update last login
        $this->userModel->updateLastLogin($user['id']);

        return redirect()->to('/dashboard')
            ->with('success', 'Selamat datang, ' . $user['nama_lengkap']);
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')
            ->with('success', 'Anda telah berhasil logout');
    }
}
