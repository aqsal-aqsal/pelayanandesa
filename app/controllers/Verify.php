<?php

class Verify extends Controller {
    public function index($token = null) {
        $data['judul'] = 'Verifikasi Dokumen';
        $data['public_page'] = true;
        if ($token) {
            $data['surat'] = $this->model('SuratModel')->getByQrToken($token);
        } else {
            $data['surat'] = null;
        }
        
        $this->view('verify/index', $data);
    }

    public function check() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'] ?? null;
            if ($token) {
                header('Location: ' . BASEURL . '/verify/' . $token);
                exit;
            }
        }
        header('Location: ' . BASEURL . '/verify');
        exit;
    }
}
