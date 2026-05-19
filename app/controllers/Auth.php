<?php

class Auth extends Controller {
    public function index() {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Login';
        $this->view('auth/login', $data);
    }

    public function login() {
        $nik = $_POST['nik'];
        $password = $_POST['password'];

        $userModel = $this->model('UserModel');
        $user = $userModel->getUserByNik($nik);

        if ($user) {
            // In a real app, use password_verify. For this demo, we might need to check if password is hashed or plain
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user'] = $user;
                
                // Redirect based on level
                if ($user['level'] == 'kades') {
                    header('Location: ' . BASEURL . '/dashboard/kades');
                } elseif ($user['level'] == 'petugas') {
                    header('Location: ' . BASEURL . '/dashboard/petugas');
                } else {
                    header('Location: ' . BASEURL . '/dashboard/warga');
                }
                exit;
            }
        }

        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'NIK atau Password salah!'
        ];
        header('Location: ' . BASEURL . '/auth');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}
