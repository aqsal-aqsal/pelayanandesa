<?php

class Home extends Controller {
    public function index() {
        $data['judul'] = 'Home';
        $data['public_page'] = true;
        $this->view('home/index', $data);
    }
}
