<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';
require_once __DIR__ . '/../models/DosenModel.php';
require_once __DIR__ . '/../models/PegawaiModel.php';
require_once __DIR__ . '/../models/PengumumanModel.php';

class DashboardController {
    private $mahasiswaModel;
    private $dosenModel;
    private $pegawaiModel;
    private $pengumumanModel;

    public function __construct() {
        $this->mahasiswaModel  = new MahasiswaModel();
        $this->dosenModel      = new DosenModel();
        $this->pegawaiModel    = new PegawaiModel();
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index() {
        // Mengambil total jumlah statistik data
        $totalMahasiswa  = $this->mahasiswaModel->getTotalMahasiswa();
        $totalDosen      = $this->dosenModel->getTotalDosen();
        $totalPegawai    = $this->pegawaiModel->getTotalPegawai();
        $totalPengumuman = $this->pengumumanModel->getTotalPengumuman();

        // Mengambil 3 pengumuman terbaru
        $latestPengumuman = $this->pengumumanModel->getPengumumanPage(3, 0);

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}