<?php
require_once __DIR__ . '/../config/Database.php';

class PegawaiModel extends Database {
    private $table = 'tb_pegawai';

    public function getAllPegawai() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id_pegawai DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPegawaiById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_pegawai = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function tambahPegawai($data) {
        $query = "INSERT INTO " . $this->table . " (nip_pegawai, nama_pegawai, jenis_kelamin, email, jenis_pegawai, status_pegawai, status_aktif, no_hp) 
                  VALUES (:nip_pegawai, :nama_pegawai, :jenis_kelamin, :email, :jenis_pegawai, :status_pegawai, :status_aktif, :no_hp)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nip_pegawai', $data['nip_pegawai']);
        $stmt->bindParam(':nama_pegawai', $data['nama_pegawai']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':jenis_pegawai', $data['jenis_pegawai']);
        $stmt->bindParam(':status_pegawai', $data['status_pegawai']);
        $stmt->bindParam(':status_aktif', $data['status_aktif']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        return $stmt->execute();
    }

    public function updatePegawai($data) {
        $query = "UPDATE " . $this->table . " 
                  SET nip_pegawai = :nip_pegawai, nama_pegawai = :nama_pegawai, jenis_kelamin = :jenis_kelamin, 
                      email = :email, jenis_pegawai = :jenis_pegawai, status_pegawai = :status_pegawai, 
                      status_aktif = :status_aktif, no_hp = :no_hp 
                  WHERE id_pegawai = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $data['id_pegawai'], PDO::PARAM_INT);
        $stmt->bindParam(':nip_pegawai', $data['nip_pegawai']);
        $stmt->bindParam(':nama_pegawai', $data['nama_pegawai']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':jenis_pegawai', $data['jenis_pegawai']);
        $stmt->bindParam(':status_pegawai', $data['status_pegawai']);
        $stmt->bindParam(':status_aktif', $data['status_aktif']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        return $stmt->execute();
    }

    public function hapusPegawai($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_pegawai = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function checkDuplicate($nip_pegawai, $email, $excludeId = null) {
        $conditions = [];
        if (!empty($nip_pegawai)) {
            $conditions[] = "nip_pegawai = :nip_pegawai";
        }
        if (!empty($email)) {
            $conditions[] = "email = :email";
        }

        if (empty($conditions)) {
            return false;
        }

        $query = "SELECT * FROM " . $this->table . " WHERE (" . implode(" OR ", $conditions) . ")";
        if ($excludeId) {
            $query .= " AND id_pegawai != :id";
        }

        $stmt = $this->conn->prepare($query);
        if (!empty($nip_pegawai)) {
            $stmt->bindParam(':nip_pegawai', $nip_pegawai);
        }
        if (!empty($email)) {
            $stmt->bindParam(':email', $email);
        }
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTotalPegawai($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                      WHERE nama_pegawai LIKE :keyword OR nip_pegawai LIKE :keyword OR jenis_pegawai LIKE :keyword";
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

    public function getPegawaiPage($limit, $offset, $keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE nama_pegawai LIKE :keyword OR nip_pegawai LIKE :keyword OR jenis_pegawai LIKE :keyword 
                      ORDER BY id_pegawai DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_pegawai DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPegawaiExport($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE nama_pegawai LIKE :keyword OR nip_pegawai LIKE :keyword OR jenis_pegawai LIKE :keyword 
                      ORDER BY nama_pegawai ASC";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY nama_pegawai ASC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
}