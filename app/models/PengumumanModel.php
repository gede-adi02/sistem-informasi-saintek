<?php
require_once __DIR__ . '/../config/Database.php';

class PengumumanModel extends Database {
    private $table = 'tb_pengumuman';

    public function getTotalPengumuman($keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE judul LIKE :keyword OR kategori LIKE :keyword";
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

    public function getPengumumanPage($limit, $offset, $keyword = '') {
        if (!empty($keyword)) {
            $query = "SELECT p.*, u.nama_lengkap as penulis FROM " . $this->table . " p 
                      JOIN tb_user u ON p.penulis_id = u.id_user 
                      WHERE p.judul LIKE :keyword OR p.kategori LIKE :keyword 
                      ORDER BY p.id_pengumuman DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $searchKey = "%" . $keyword . "%";
            $stmt->bindParam(':keyword', $searchKey);
        } else {
            $query = "SELECT p.*, u.nama_lengkap as penulis FROM " . $this->table . " p 
                      JOIN tb_user u ON p.penulis_id = u.id_user 
                      ORDER BY p.id_pengumuman DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPengumumanById($id) {
        $query = "SELECT p.*, u.nama_lengkap as penulis FROM " . $this->table . " p 
                  JOIN tb_user u ON p.penulis_id = u.id_user 
                  WHERE p.id_pengumuman = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function tambahPengumuman($data) {
        $query = "INSERT INTO " . $this->table . " (judul, kategori, isi_pengumuman, penulis_id) 
                  VALUES (:judul, :kategori, :isi_pengumuman, :penulis_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':isi_pengumuman', $data['isi_pengumuman']);
        $stmt->bindParam(':penulis_id', $data['penulis_id'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updatePengumuman($data) {
        $query = "UPDATE " . $this->table . " 
                  SET judul = :judul, kategori = :kategori, isi_pengumuman = :isi_pengumuman 
                  WHERE id_pengumuman = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $data['id_pengumuman'], PDO::PARAM_INT);
        $stmt->bindParam(':judul', $data['judul']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':isi_pengumuman', $data['isi_pengumuman']);
        return $stmt->execute();
    }

    public function hapusPengumuman($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_pengumuman = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}