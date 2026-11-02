<?php
require_once __DIR__ . '/../models/MahasiswaModel.php';

class MahasiswaController {
    private $model;

    public function __construct() {
        $this->model = new MahasiswaModel();
    }

    public function index() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $limit     = 10;
        $page = isset($_GET['page_num']) && is_numeric($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        if ($page < 1) $page = 1;

        $totalData  = $this->model->getTotalMahasiswa($keyword);
        $totalPages = ceil($totalData / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }

        $offset    = ($page - 1) * $limit;
        $mahasiswa = $this->model->getMahasiswaPage($limit, $offset, $keyword);
        require_once __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/mahasiswa/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nim    = trim($_POST['nim']);
            $nama   = trim($_POST['nama']);
            $email  = trim($_POST['email']);
            $prodi  = trim($_POST['prodi']);
            $alamat = trim($_POST['alamat'] ?? '');
            $no_hp  = trim($_POST['no_hp'] ?? '');

            if (!ctype_digit($nim)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIM hanya boleh berisi angka (0-9)!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }
            if (strlen($nim) > 20) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIM tidak boleh lebih dari 20 digit!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }
            if (strlen($nama) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email tidak valid!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }
            if (strlen($email) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            if (preg_match('/[0-9]/', $prodi)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Program Studi tidak boleh mengandung angka!'
                ];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }
            if (strlen($prodi) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Program Studi tidak boleh lebih dari 100 karakter!'
                ];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            if (strlen($alamat) > 1000) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Alamat terlalu panjang (maksimal 1000 karakter)!'
                ];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka (0-9)!'];
                    header('Location: index.php?page=mahasiswa&action=tambah');
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=mahasiswa&action=tambah');
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nim, $nama, $email);
            if ($check) {
                $duplikat = [];
                if ($check['nim'] === $nim) $duplikat[] = "NIM";
                if ($check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=mahasiswa&action=tambah');
                exit;
            }

            $data = [
                'nim'           => $nim,
                'nama'          => $nama,
                'jenis_kelamin' => $_POST['jenis_kelamin'],
                'email'         => $email,
                'prodi'         => $prodi,
                'semester'      => $_POST['semester'],
                'no_hp'         => $no_hp,
                'alamat'        => $alamat
            ];

            if ($this->model->tambahMahasiswa($data)) {
                unset($_SESSION['old_input']);
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data mahasiswa berhasil ditambahkan!'
                ];
                header('Location: index.php?page=mahasiswa&action=index');
                exit;
            }
        }
    }

    public function edit($id) {
        $mahasiswa = $this->model->getMahasiswaById($id);
        require_once __DIR__ . '/../views/mahasiswa/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id_mahasiswa'];
            $nim    = trim($_POST['nim']);
            $nama   = trim($_POST['nama']);
            $email  = trim($_POST['email']);
            $prodi  = trim($_POST['prodi']);
            $alamat = trim($_POST['alamat'] ?? '');
            $no_hp  = trim($_POST['no_hp'] ?? '');

            if (!ctype_digit($nim)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIM hanya boleh berisi angka (0-9)!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nim) > 20) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIM tidak boleh lebih dari 20 digit!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nama) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email tidak valid!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }
            if (strlen($email) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            if (preg_match('/[0-9]/', $prodi)) {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Program Studi tidak boleh mengandung angka!'
                ];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }
            if (strlen($prodi) > 100) {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Program Studi tidak boleh lebih dari 100 karakter!'
                ];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            if (strlen($alamat) > 1000) {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Alamat terlalu panjang (maksimal 1000 karakter)!'
                ];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka (0-9)!'];
                    header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nim, $nama, $email, $id);
            if ($check) {
                $duplikat = [];
                if ($check['nim'] === $nim) $duplikat[] = "NIM";
                if ($check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=mahasiswa&action=edit&id=' . $id);
                exit;
            }

            $data = [
                'id_mahasiswa'  => $id,
                'nim'           => $nim,
                'nama'          => $nama,
                'jenis_kelamin' => $_POST['jenis_kelamin'],
                'email'         => $email,
                'prodi'         => $prodi,
                'semester'      => $_POST['semester'],
                'no_hp'         => $no_hp,
                'alamat'        => $alamat
            ];

            if ($this->model->updateMahasiswa($data)) {
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data mahasiswa berhasil diperbarui!'
                ];
                header('Location: index.php?page=mahasiswa&action=index');
                exit;
            }
        }
    }

    public function hapus($id) {
        if ($this->model->hapusMahasiswa($id)) {
            $_SESSION['flash'] = [
                'type'  => 'success',
                'pesan' => 'Data mahasiswa berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Gagal menghapus data mahasiswa!'
            ];
        }
        header('Location: index.php?page=mahasiswa&action=index');
        exit;
    }

    public function eksporExcel() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $mahasiswa = $this->model->getAllMahasiswaExport($keyword);

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Mahasiswa_" . date('Ymd_His') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        echo "<thead>
                <tr style='background-color: #007bff; color: #ffffff;'>
                    <th>No</th><th>NIM</th><th>Nama Lengkap</th><th>JK</th><th>Email</th><th>Prodi</th><th>Semester</th><th>No HP</th><th>Alamat</th>
                </tr>
            </thead><tbody>";
        if (!empty($mahasiswa)) {
            $no = 1;
            foreach ($mahasiswa as $mhs) {
                echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>'" . htmlspecialchars($mhs['nim']) . "</td>
                        <td>" . htmlspecialchars($mhs['nama']) . "</td>
                        <td>" . htmlspecialchars($mhs['jenis_kelamin']) . "</td>
                        <td>" . htmlspecialchars($mhs['email']) . "</td>
                        <td>" . htmlspecialchars($mhs['prodi']) . "</td>
                        <td>" . htmlspecialchars($mhs['semester']) . "</td>
                        <td>" . htmlspecialchars($mhs['no_hp']) . "</td>
                        <td>" . htmlspecialchars($mhs['alamat']) . "</td>
                    </tr>";
            }
        }
        echo "</tbody></table>";
        exit;
    }

    public function cetakPdf() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $mahasiswa = $this->model->getAllMahasiswaExport($keyword);
        require_once __DIR__ . '/../views/mahasiswa/cetak.php';
    }
}