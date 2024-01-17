<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

class ProyekModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'master_pkp';
    protected $primaryKey       = 'id_pkp';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id_pkp",
        "kode",
        "id_instansi",
        "no_pkp",
        "proyek",
        "alias",
        "dtu_nama",
        "dtu_pemilik",
        "dtu_jenis",
        "dtu_lokasi",
        "dtu_periode",
        "foto",
        "tgl_mulai",
        "tgl_selesai",
        "id_kapro",
        "id_admin",
        "alamat",
        "kota",
        "telp_proyek",
        "email_proyek",
        "keterangan",
        "status",
        "status_proyek",
        "kunci",
        "tgl_ubah",
        "id_ubah",
        "tgl_ubah_dtu",
        "file_dtu",
        "id_solusi",
        "tgl_ubah_masalah",
        "id_dcr",
        "tgl_awal_dcr",
        "tgl_ubah_dcr",
        "tgl_ubah_gbr",
        "tgl_ubah_dtt",
        "tgl_ubah_progress",
        "tgl_ubah_absensi",
        "tgl_ubah_inventaris",
        "tgl_close",
        "warning",
        "late",
        "qr_bp",
        "acc_bp",
        "ijin_kadiv",
        "ijin_kadirat",
        "validasi_kapro",
        "nilai_jaminan",
        "tgl_jaminan",
        "bast_1",
        "bast_2",
        "referensi",
        "qs",
        "periode_akhir",
        "update_qs"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllPKP()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '511')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratPKP()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '511')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiPKP($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '511')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekPKP($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '511')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getAllPKP2()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratPKP2()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiPKP2($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekPKP2($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }



    public function getAllPKP3()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratPKP3()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiPKP3($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekPKP3($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '613')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getAllKtlPKP1()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '611')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratKtlPKP1()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '611')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiKtlPKP1($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '611')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekKtlPKP1($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '611')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getAllKtlPKP2()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '612')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratKtlPKP2()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '612')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiKtlPKP2($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '612')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekKtlPKP2($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '612')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getAllTransPKP1()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratTransPKP1()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiTransPKP1($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekTransPKP1($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getAllTransPKP2()
    {
        return $this->db->table("master_pkp a")
            ->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getWakadiratTransPKP2()
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getDivisiTransPKP2($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('b.id', $id_divisi)
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekTransPKP2($pkp_user)
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp, a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_pkp', $pkp_user)
            ->where('b.nomor', '712')
            ->where('a.no_pkp !=', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }



    public function getAllKantorPKP()
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp,a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.no_pkp', '000')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekKantorPKP($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp,a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.no_pkp', '000')
            ->where('a.id_instansi', $id_divisi)
            ->get() // Perform the query
            ->getResult(); // Return the resul
    }

    public function getAllSemuaPKP()
    {
        // PROYEK
        return $this->db->table("master_pkp a")->select("a.id_pkp,a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->orderBy('a.no_pkp')
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getProyekSemuaPKP($id_divisi)
    {
        return $this->db->table("master_pkp a")->select("a.id_pkp,a.tgl_ubah_progress, a.alias, a.no_pkp, a.proyek, a.status, a.id_instansi, a.tgl_ubah, a.kunci, b.id, b.nomor, b.nama")
            ->join('master_instansi b', 'a.id_instansi = b.id')
            ->where('a.id_instansi', $id_divisi)
            ->get() // Perform the query
            ->getResult(); // Return the result
    }

    public function getBukaAkses2($kode_akses)
    {
        return $this->db->table("buka_akses")->select("*")->where('kode', $kode_akses)->get()->getResult();
    }

    public function getBukaAkses22($kode_akses2)
    {
        return $this->db->table("buka_akses")->select("*")->where('kode', $kode_akses2)->get()->getResult();
    }

    public function getInvent1($kode)
    {
        return $this->db->table("inventaris a")
            ->select("a.nomor, a.sn, a.status, a.jns_brng, a.merek, a.spek, a.kondisi, a.pemakai, a.foto, a.kode")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->where('a.id_pkp', $kode)
            ->where('a.type', 'FURNITURE')
            ->orderBy('a.nomor', 'ASC')->get()->getResult();
    }

    public function getInvent2($kode)
    {
        return $this->db->table("inventaris a")
            ->select("a.nomor, a.sn, a.status, a.jns_brng, a.merek, a.spek, a.kondisi, a.pemakai, a.foto, a.kode")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->where('a.id_pkp', $kode)
            ->where('a.type', 'KOMPUTER/ACC')
            ->orderBy('a.nomor', 'ASC')->get()->getResult();
    }

    public function getInvent3($kode)
    {
        return $this->db->table("inventaris a")
            ->select("a.nomor, a.sn, a.status, a.jns_brng, a.merek, a.spek, a.kondisi, a.pemakai, a.foto, a.kode")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->where('a.id_pkp', $kode)
            ->where('a.type', 'KENDARAAN')
            ->orderBy('a.nomor', 'ASC')->get()->getResult();
    }

    public function getGambar($kode)
    {
        return $this->db->table("gambar a")
            ->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->where('a.id_pkp', $kode)
            ->where('a.tgl_ubah = b.tgl_ubah_gbr')
            ->orderBy("a.kode", "desc")->get();
    }

    public function upload_file($nama_file)
    {
        $config = [
            'upload_path' => './excel/',
            'allowed_types' => 'xlsx',
            'file_name' => $nama_file,
            'max_size' => 2048,
            'overwrite' => true,
        ];
        $upload = Services::upload($config);
        $file = $this->request->getFile('excelfile');
        if ($file->isValid() && !$file->hasMoved()) {
            $file->move($config['upload_path'], $config['file_name']);

            // File uploaded successfully
            $data = [
                'file_name' => $file->getName(),
                'file_path' => $config['upload_path'] . $file->getName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
            ];

            $aksi['result'] = 'success';
            $aksi['file'] = $data;
        } else {
            // Upload failed
            $error = $file->getErrorString();
            $aksi['result'] = 'failed';
            $aksi['error'] = $error;
        }
    }

    public function input_semua3b($data)
    {
        return $this->db->table('solusi')->insertBatch($data);
    }

    public function simpantglclose($postData)
    {
        //THBL TGL BERJALAN//
        $tgl_mutasi2 = $postData['tgl_close'];
        $tgl_mutasi = date('Y-m-d', strtotime($tgl_mutasi2));


        $dataend = [
            "tgl_close" => $tgl_mutasi,
        ];
        return $this->db->table('master_pkp')->where('id_pkp', $postData['id_pkp'])->update($dataend);
    }

    public function simpandatadtu($id_pkp, $files)
    {
        helper(['form', 'url']);
        $db = db_connect();

        date_default_timezone_set("Asia/Jakarta");
        $now = date("Y-m-d");

        // Fetch data from database
        $masterPKP = $this->where('id_pkp', $id_pkp)->first();
        $no_pkp = $masterPKP['no_pkp'];
        $id_instansi = $masterPKP['id_instansi'];

        $masterInstansiModel = new MasterInstansiModel(); // Assume you have this model
        $masterInstansi = $masterInstansiModel->find($id_instansi);
        $no_instansi = $masterInstansi['nomor'];

        $lokasi = WRITEPATH . 'assets/' . $no_instansi . '/' . $no_pkp;

        if ($files) {
            $u = 1;
            foreach ($files['berkas'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = 'dtu' . $no_pkp . '_' . $u . '.' . $file->getExtension();
                    $file->move($lokasi, $newName);

                    if ($u == 1) {
                        $this->update($id_pkp, ['file_dtu' => $lokasi . '/' . $newName]);
                    }
                    $u++;
                }
            }
        }

        return $this->update($id_pkp, ['tgl_ubah_dtu' => $now]);
    }
}