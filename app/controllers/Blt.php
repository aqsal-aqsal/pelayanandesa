<?php

class Blt extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Bantuan Langsung Tunai (BLT)';
        $bltModel = $this->model('BltModel');
        $data['programs'] = $bltModel->getPrograms();
        $this->view('blt/index', $data);
    }

    public function detail($id_program) {
        $bltModel = $this->model('BltModel');
        $data['judul'] = 'Detail Seleksi BLT';
        $data['program'] = null; // Get from DB
        $data['hasil'] = $bltModel->getHasilSAW($id_program);
        $this->view('blt/detail', $data);
    }

    public function admin() {
        if ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Manajemen Seleksi BLT';
        $bltModel = $this->model('BltModel');
        $data['programs'] = $bltModel->getPrograms();
        $this->view('blt/admin', $data);
    }

    public function hitung($id_program) {
        if ($_SESSION['user']['level'] != 'kades' && $_SESSION['user']['level'] != 'petugas') {
            exit;
        }
        $bltModel = $this->model('BltModel');
        if ($bltModel->calculateSAW($id_program)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Perhitungan SAW selesai!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghitung. Pastikan data calon dan nilai kriteria sudah lengkap.'];
        }
        header('Location: ' . BASEURL . '/blt/admin');
        exit;
    }
}
