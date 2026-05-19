<?php

class UserModel {
    private $table = 'user';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getUserByNik($nik) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nik=:nik');
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_user=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function authenticate($nik, $password) {
        $user = $this->getUserByNik($nik);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($data) {
        $query = "INSERT INTO " . $this->table . " (nik, password, level, status_aktif, created_at, email, no_hp) 
                  VALUES (:nik, :password, :level, :status_aktif, NOW(), :email, :no_hp)";
        
        $this->db->query($query);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('level', $data['level'] ?? 'masyarakat');
        $this->db->bind('status_aktif', 1);
        $this->db->bind('email', $data['email']);
        $this->db->bind('no_hp', $data['no_hp']);

        return $this->db->execute();
    }
}
