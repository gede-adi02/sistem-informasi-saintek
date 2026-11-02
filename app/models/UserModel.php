<?php
require_once __DIR__ . '/../config/Database.php';

class UserModel extends Database {
    private $table = 'tb_user';

    public function findByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE username = :username AND status_akun = 'aktif'");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function checkDuplicateUsername($username, $excludeId = null) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        if ($excludeId) {
            $query .= " AND id_user != :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTotalUser($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE username LIKE :keyword OR nama_lengkap LIKE :keyword OR level_user LIKE :keyword";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getUserPage($limit, $offset, $keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " WHERE username LIKE :keyword OR nama_lengkap LIKE :keyword OR level_user LIKE :keyword ORDER BY id_user DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_user DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_user = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function tambahUser($data) {
        $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, level_user, status_akun) 
        VALUES (:username, :password, :nama_lengkap, :level_user, :status_akun)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':level_user', $data['level_user']);
        $stmt->bindParam(':status_akun', $data['status_akun']);
        return $stmt->execute();
    }

    public function updateUser($data) {
        if (!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                    SET username = :username, password = :password, nama_lengkap = :nama_lengkap, 
                    level_user = :level_user, status_akun = :status_akun 
                    WHERE id_user = :id";
        } else {
            $query = "UPDATE " . $this->table . " 
                    SET username = :username, nama_lengkap = :nama_lengkap, 
                    level_user = :level_user, status_akun = :status_akun 
                    WHERE id_user = :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $data['id_user'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':level_user', $data['level_user']);
        $stmt->bindParam(':status_akun', $data['status_akun']);
        if (!empty($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }
        return $stmt->execute();
    }

    public function hapusUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_user = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}