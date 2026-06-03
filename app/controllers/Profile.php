<?php

class Profile extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Pengaturan Profil';
        $userModel = $this->model('UserModel');
        $data['user'] = $userModel->getUserById($_SESSION['user']['id_user']);
        
        if ($_SESSION['user']['level'] == 'masyarakat') {
            $data['warga'] = $this->model('WargaModel')->getWargaByNik($data['user']['nik']);
            $this->view('profile/warga', $data);
        } else {
            $data['petugas'] = $this->model('PetugasModel')->getById($_SESSION['user']['id_user']);
            $this->view('profile/admin', $data);
        }
    }

    public function update_warga() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $wargaModel = $this->model('WargaModel');
            if ($wargaModel->updateWarga($_POST)) {
                // Handle photo upload if any
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                    $target_dir = "assets/img/profile/";
                    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
                    $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                    $filename = $_SESSION['user']['nik'] . '.' . $file_extension;
                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $filename);
                    
                    // Update photo in DB (assuming column exists or we just use NIK)
                }

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui!'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal memperbarui profil.'];
            }
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }

    public function update_account() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $id_user = $_SESSION['user']['id_user'];
            
            // Update Password if provided
            if (!empty($_POST['new_password'])) {
                $userModel->updatePassword($id_user, $_POST['new_password']);
            }
            
            // Update other fields
            $data = [
                'id_user' => $id_user,
                'email' => $_POST['email'],
                'no_hp' => $_POST['no_hp']
            ];
            $userModel->updateProfile($data);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data akun berhasil diperbarui!'];
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }
}