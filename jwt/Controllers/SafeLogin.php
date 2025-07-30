<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\Cookie\Cookie;
use Firebase\JWT\JWT;

class SafeLogin extends BaseController
{
    public function index(){
        helper(['form']);
        return view('safe_login');
    }

    public function jwt_valid(){
        echo "JWT VALID! <a href='/jwt/logout'>Logout</a>";
    }

    public function logout() {
        $response = service('response');

        // Delete the cookie
        $response->deleteCookie('auth_token');

        // Optionally return a response
        return $response->setJSON([
            'status' => true,
            'message' => 'Logged out successfully. Token removed.',
        ]);
    }


    public function submit()
    {
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
            return view('/safe_login', [
                'validation' => $this->validator
            ]);
        }

        $user = $userModel->where('email', $data['email'])->first();

        // Cek apakah user ada dan password cocok
        // if ($user && password_verify($data['password'], $user['password'])) {
        if ($user && $data['password'] === $user['password']) {
            // Login sukses

            // Simpan data ke JSON Web Token (JWT)

            $key = getenv('JWT_SECRET');
            $iat = time(); //Current Time
            $expired = $iat + (60*15);

            $payload = [
                'iss' => 'issuer_by',
                'uid' => $user['id'],
                'email' => $user['email'],
                'iat' => $iat,
                'exp' => $expired,
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            $cookie = new Cookie(
                'auth_token',        // name
                $token,              // value
                [
                    'expires'  => $expired, // expires in 15 minutes
                    'httponly' => true,
                    'secure'   => true,
                    'samesite' => 'Strict' // use 'Lax' or 'None' depending on your needs
                ]
            );

            // Set the cookie in response
            $response = service('response');
            $response->setCookie($cookie);

            // Optional: return a response to the user
            return $response->setJSON(['message' => 'Token set in cookie successfully.']);
            // Redirect ke halaman dashboard atau lainnya
            // return redirect()->to('/admin/dashboard');
        } else {
            // Login gagal, beri error manual
            return view('/safe_login', [
                'loginError' => 'Email atau password salah.'
            ]);
        }
    }
}
