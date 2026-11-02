<?php
require_once __DIR__ . '/../config/Database.php';

class MahasiswaModel extends Database {
    private $table = 'tb_mahasiswa';

    public function getAllMahasiswa() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY id_mahasiswa DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMahasiswaById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_mahasiswa = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function tambahMahasiswa($data) {
        $query = "INSERT INTO " . $this->table . " (nim, nama, jenis_kelamin, email, prodi, semester, no_hp, alamat) 
                  VALUES (:nim, :nama, :jenis_kelamin, :email, :prodi, :semester, :no_hp, :alamat)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $data['nim']);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':semester', $data['semester'], PDO::PARAM_INT);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        $stmt->bindParam(':alamat', $data['alamat']);

        return $stmt->execute();
    }

    public function updateMahasiswa($data) {
        $query = "UPDATE " . $this->table . " 
                  SET nim = :nim, nama = :nama, jenis_kelamin = :jenis_kelamin, email = :email, 
                      prodi = :prodi, semester = :semester, no_hp = :no_hp, alamat = :alamat 
                  WHERE id_mahasiswa = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $data['id_mahasiswa'], PDO::PARAM_INT);
        $stmt->bindParam(':nim', $data['nim']);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':prodi', $data['prodi']);
        $stmt->bindParam(':semester', $data['semester'], PDO::PARAM_INT);
        $stmt->bindParam(':no_hp', $data['no_hp']);
        $stmt->bindParam(':alamat', $data['alamat']);

        return $stmt->execute();
    }

    public function hapusMahasiswa($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_mahasiswa = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function checkDuplicate($nim, $nama, $email, $excludeId = null) {
        $query = "SELECT * FROM " . $this->table . " WHERE (nim = :nim OR email = :email)";
        if ($excludeId) {
            $query .= " AND id_mahasiswa != :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':email', $email);
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function cariMahasiswa($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                WHERE nama LIKE :keyword OR nim LIKE :keyword 
                ORDER BY id DESC";
        
        $stmt = $this->conn->prepare($query);
        $searchKey = "%" . $keyword . "%";
        $stmt->bindParam(':keyword', $searchKey);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalMahasiswa($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE nama LIKE :keyword OR nim LIKE :keyword";
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

    public function getMahasiswaPage($limit, $offset, $keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " WHERE nama LIKE :keyword OR nim LIKE :keyword ORDER BY id_mahasiswa DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_mahasiswa DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllMahasiswaExport($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT * FROM " . $this->table . " WHERE nama LIKE :keyword OR nim LIKE :keyword ORDER BY nim ASC";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT * FROM " . $this->table . " ORDER BY nim ASC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
}