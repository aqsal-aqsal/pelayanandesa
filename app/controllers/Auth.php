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

    public function register() {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $data['judul'] = 'Registrasi';
            $this->view('auth/register', $data);
            return;
        }

        $nik = $_POST['nik'];
        $password = $_POST['password'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $rt_rw = $_POST['rt_rw'] ?? null;
        $pekerjaan = $_POST['pekerjaan'] ?? null;
        $penghasilan = $_POST['penghasilan'] ?? null;
        $jumlah_tanggungan = $_POST['jumlah_tanggungan'] ?? null;
        $kondisi_rumah = $_POST['kondisi_rumah'] ?? null;
        $status_kawin = $_POST['status_kawin'];
        $no_hp = $_POST['no_hp'] ?? null;
        $email = $_POST['email'] ?? null;

        // Validasi NIK hanya angka
        if (!ctype_digit($nik)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK hanya boleh berisi angka.'];
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->getUserByNik($nik)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'NIK sudah terdaftar. Silakan login.'];
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $wargaModel = $this->model('WargaModel');
        if (!$wargaModel->getWargaByNik($nik)) {
            $wargaModel->addWarga([
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $jenis_kelamin,
                'alamat' => $alamat,
                'rt_rw' => $rt_rw,
                'pekerjaan' => $pekerjaan,
                'penghasilan' => $penghasilan,
                'jumlah_tanggungan' => $jumlah_tanggungan,
                'kondisi_rumah' => $kondisi_rumah,
                'status_kawin' => $status_kawin
            ]);
        }

        if ($userModel->register([
            'nik' => $nik,
            'password' => $password,
            'level' => 'masyarakat',
            'email' => $email,
            'no_hp' => $no_hp
        ])) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registrasi berhasil! Silakan login.'];
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Registrasi gagal. Silakan coba lagi.'];
        header('Location: ' . BASEURL . '/auth/register');
        exit;
    }

    public function login() {
        $nik = $_POST['nik'];
        $password = $_POST['password'];

        $userModel = $this->model('UserModel');
        $user = $userModel->getUserByNik($nik);

        if ($user) {
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user'] = $user;

                if ($user['level'] == 'petugas' || $user['level'] == 'kades') {
                    $db = new Database;
                    $db->query('SELECT id_petugas FROM petugas WHERE id_petugas = :id');
                    $db->bind('id', $user['id_user']);
                    $exists = $db->single();

                    if (!$exists) {
                        $db->query('INSERT INTO petugas (id_petugas, nama_petugas, jabatan, status_aktif, created_at) VALUES (:id, :nama, :jabatan, 1, NOW())');
                        $db->bind('id', $user['id_user']);
                        $db->bind('nama', $user['nik']);
                        $db->bind('jabatan', $user['level'] == 'kades' ? 'Kepala Desa' : 'Petugas');
                        $db->execute();
                    }
                }
                
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
