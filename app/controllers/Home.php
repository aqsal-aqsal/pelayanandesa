<?php

class Home extends Controller {
    public function index() {
        $data['judul'] = 'Home';
        $data['public_page'] = true;
        $data['berita'] = $this->model('InformasiModel')->getLatestInformasi(3);
        $this->view('home/index', $data);
    }
}
