<?php
require_once __DIR__ . '/../config/Database.php';

class DosenModel extends Database {
    private $table = 'tb_dosen';

    public function getAllDosen() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id_dosen DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getDosenById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_dosen = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function tambahDosen($data) {
        $query = "INSERT INTO " . $this->table . " (nip, nidn, nama_dosen, jenis_kelamin, email, prodi, jabatan_fungsional, no_hp) 
                  VALUES (:nip, :nidn, :nama_dosen, :jenis_kelamin, :email, :prodi, :jabatan_fungsional, :no_hp)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nip', $data['nip']);
        $stmt->bindParam(':nidn', $data['nidn']);
        $stmt->bindParam(':nama_dosen', $data['nama_dosen']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':jabatan_fungsional', $data['jabatan_fungsional']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        return $stmt->execute();
    }

    public function updateDosen($data) {
        $query = "UPDATE " . $this->table . " 
                  SET nip = :nip, nidn = :nidn, nama_dosen = :nama_dosen, jenis_kelamin = :jenis_kelamin, 
                      email = :email, prodi = :prodi, jabatan_fungsional = :jabatan_fungsional, no_hp = :no_hp 
                  WHERE id_dosen = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $data['id_dosen'], PDO::PARAM_INT);
        $stmt->bindParam(':nip', $data['nip']);
        $stmt->bindParam(':nidn', $data['nidn']);
        $stmt->bindParam(':nama_dosen', $data['nama_dosen']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':jabatan_fungsional', $data['jabatan_fungsional']);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        return $stmt->execute();
    }

    public function hapusDosen($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_dosen = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function checkDuplicate($nidn, $nip, $email, $excludeId = null) {
        $query = "SELECT * FROM " . $this->table . " WHERE (nidn = :nidn OR email = :email";
        if (!empty($nip)) {
            $query .= " OR nip = :nip";
        }
        $query .= ")";

        if ($excludeId) {
            $query .= " AND id_dosen != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nidn', $nidn);
        $stmt->bindParam(':email', $email);
        if (!empty($nip)) {
            $stmt->bindParam(':nip', $nip);
        }
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTotalDosen($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                      WHERE nama_dosen LIKE :keyword OR nidn LIKE :keyword OR nip LIKE :keyword";
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

    public function getDosenPage($limit, $offset, $keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE nama_dosen LIKE :keyword OR nidn LIKE :keyword OR nip LIKE :keyword 
                      ORDER BY id_dosen DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_dosen DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllDosenExport($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE nama_dosen LIKE :keyword OR nidn LIKE :keyword OR nip LIKE :keyword 
                      ORDER BY nama_dosen ASC";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY nama_dosen ASC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
}