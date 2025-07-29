<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Login extends BaseController
{
    public function index(): string
    {
        helper(['form']);
        return view('login');
    }

    public function logout() {
        session()->destroy();
        return redirect()->route('login');
    }

    public function submit() {
        helper(['form']);

        $userModel = new UsersModel();

        $data = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (! $this->validate($rules)) {
            return view('/login', [
                'validation' => $this->validator
            ]);
        }

        $user = $userModel->where('email', $data['email'])->first();

        // Cek apakah user ada dan password cocok
        // if ($user && password_verify($data['password'], $user['password'])) {
        if ($user && $data['password'] === $user['password']) {
            // Login sukses

            // Simpan data ke session
            session()->set([
                'user_id' => $user['id'],
                'email'   => $user['email'],
                'isLoggedIn' => true
            ]);

            // Redirect ke halaman dashboard atau lainnya
            return redirect()->to('/admin/dashboard');
        } else {
            // Login gagal, beri error manual
            return view('/login', [
                'loginError' => 'Email atau password salah.'
            ]);
        }
    }

    public function register() {
        helper(['form']);

        $userModel = new UsersModel();

        $data = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'pass_confirm' => $this->request->getPost('pass_confirm')
        ];

        // Aturan validasi
        $rules = [
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]'
        ];

        if (! $this->validate($rules)) {
            return view('/register', [
                'validation' => $this->validator
            ]);
        }

        // Simpan user ke database (tanpa hash, sesuai struktur login-mu)
        $userModel->save([
            'email'    => $data['email'],
            'password' => $data['password'] // Pastikan nanti pakai hash di real case!
        ]);

        // Setelah berhasil register, redirect ke login
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
   
}
