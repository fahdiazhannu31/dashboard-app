<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DashboardModel;
use App\Models\LoginModel;
use App\Models\ProyekModel;
use App\Models\AksesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\FPDF;
use Config\Services;


class Proyek extends BaseController
{

    public function __construct()
    {

        $this->akses = new AksesModel();
        $this->loginModel = new LoginModel();
        $this->formValidation = \Config\Services::validation();
        $this->dashboard = new DashboardModel();
        $this->proyek = new ProyekModel();
        $this->session = Services::session();
        helper(['string', 'security', 'form', 'esc']);
    }

    public function index()
    {
        $data['kode'] = '02';
        $data['judul'] = 'PROYEK';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        return view('proyek/index', $data);
    }

    public function gedung1()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['gedung1'] = $this->proyek->getAllPKP();
        } else {
            if ($isi->username == '10288') {
                $data['gedung1'] = $this->proyek->getWakadiratPKP();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['gedung1'] = $this->proyek->getDivisiPKP($id_divisi);
                } else {
                    $data['gedung1'] = $this->proyek->getProyekPKP($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">GEDUNG 1</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'Gedung 1';

        return view('proyek/gedung/gedung1', $data);
    }

    public function gedung2()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['gedung2'] = $this->proyek->getAllPKP2();
        } else {
            if ($isi->username == '10288') {
                $data['gedung2'] = $this->proyek->getWakadiratPKP2();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['gedung2'] = $this->proyek->getDivisiPKP2($id_divisi);
                } else {
                    $data['gedung2'] = $this->proyek->getProyekPKP2($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">GEDUNG 1</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'GEDUNG 2';

        return view('proyek/gedung/gedung2', $data);
    }

    public function gedung3()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['gedung3'] = $this->proyek->getAllPKP2();
        } else {
            if ($isi->username == '10288') {
                $data['gedung3'] = $this->proyek->getWakadiratPKP2();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['gedung3'] = $this->proyek->getDivisiPKP2($id_divisi);
                } else {
                    $data['gedung3'] = $this->proyek->getProyekPKP2($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">GEDUNG 1</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'GEDUNG 3';

        return view('proyek/gedung/gedung3', $data);
    }

    public function ktl1()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['ktl1'] = $this->proyek->getAllKtlPKP1();
        } else {
            if ($isi->username == '10288') {
                $data['ktl1'] = $this->proyek->getWakadiratKtlPKP1();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['ktl1'] = $this->proyek->getDivisiKtlPKP1($id_divisi);
                } else {
                    $data['ktl1'] = $this->proyek->getProyekKtlPKP1($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">KTL 1</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'KTL 1';

        return view('proyek/ktl/ktl', $data);
    }

    public function ktl2()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['ktl2'] = $this->proyek->getAllKtlPKP2();
        } else {
            if ($isi->username == '10288') {
                $data['ktl2'] = $this->proyek->getWakadiratKtlPKP2();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['ktl2'] = $this->proyek->getDivisiKtlPKP2($id_divisi);
                } else {
                    $data['ktl2'] = $this->proyek->getProyekKtlPKP2($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">KTL 2</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'KTL 2';
        return view('proyek/ktl/ktl2', $data);
    }

    public function trans1()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['trans1'] = $this->proyek->getAllTransPKP1();
        } else {
            if ($isi->username == '10288') {
                $data['trans1'] = $this->proyek->getWakadiratTransPKP1();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['trans1'] = $this->proyek->getDivisiTransPKP1($id_divisi);
                } else {
                    $data['trans1'] = $this->proyek->getProyekTransPKP1($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">TRANSPORTASI 1</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'TRANS 1';
        return view('proyek/transportasi/transportasi', $data);
    }


    public function trans2()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['trans2'] = $this->proyek->getAllTransPKP2();
        } else {
            if ($isi->username == '10288') {
                $data['trans2'] = $this->proyek->getWakadiratTransPKP2();
            } else {
                if (level_user('proyek', 'data', $kategoriQNS, 'divisi') > 0) {
                    $data['trans2'] = $this->proyek->getDivisiTransPKP2($id_divisi);
                } else {
                    $data['trans2'] = $this->proyek->getProyekTransPKP2($pkp_user);
                }
            }
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">TRANSPORTASI 2</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'TRANS 2';
        return view('proyek/transportasi/transportasi2', $data);
    }

    public function kantor()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['kantor'] = $this->proyek->getAllKantorPKP();
        } else {
            $data['kantor'] = $this->proyek->getProyekKantorPKP($id_divisi);
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">KANTOR</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'TRANS 3';
        return view('proyek/kantor/kantor', $data);
    }

    public function semua()
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        $proyek = $this->db->table('master_admin')->getWhere(['id' => $idQNS], 1);
        $pkp_user = $proyek->getRow()->pkp_user;
        //end
        //ambil divisi
        if ($pkp_user != '') {
            $divisi = $this->db->table('master_pkp')->getWhere(['id_pkp' => $pkp_user], 1);
            $id_divisi = $divisi->getRow()->id_instansi;
        }
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (level_user('proyek', 'data', $kategoriQNS, 'all') > 0) {
            $data['semua'] = $this->proyek->getAllSemuaPKP();
        } else {
            $data['semua'] = $this->proyek->getProyekSemuaPKP($id_divisi);
        }

        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a> <a style="color:white">SEMUA DATA</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['tes0'] = $this->dashboard->getId();
        $data['tes1'] = $this->dashboard->getOne();
        $data['tes2'] = $this->dashboard->getTwo();
        $data['kategori'] = $kategoriQNS;
        $data['title'] = 'SEMUA';
        return view('proyek/semua/index', $data);
    }

    public function edit_1($kode)
    {
        $data['kode'] = '02';

        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;
        $data['tahun'] = substr($tgl, 2, 2);
        $data['bulan'] = substr($tgl, 5, 2);
        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();

        $data['proyek23'] = $this->db->table('progress_proyek')->selectMax("kode")->where('id_pkp', $kode)->get();
        $kode_proyek = $data['proyek23']->getRow()->kode;
        $data['proyek22'] = $this->db->table('progress_proyek')->getWhere(['kode' => $kode_proyek]);

        if ($data['proyek22']->getNumRows() > 0) {
            $id_progress_proyek = $data['proyek22']->getRow()->id;
        } else {
            $id_progress_proyek = '';
        }
        $data['paket'] = $this->db->table("progress_paket a")->select("a.tgl_sadd,a.tgl_fadd,a.bulan,a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias,a.keterangan")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.progress_proyek', $id_progress_proyek)->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("a.bulan,a.tahun,b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id', $id_progress_proyek)->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['dt_umum'] = $this->db->table("dt_umum")->select("*")->where('pkp', $kode)->orderBy('no_urut1', 'ascd')->get()->getResult();

        $data['solusi'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'EKS')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['solusi2'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'INT')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['gambar'] = $this->db->table("gambar a")->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_gbr')->orderBy("a.kode", "desc")->get();

        $data['dcr'] = $this->db->table("dcr a")->select("a.ket1,a.ket2,a.ket3,a.ket4,a.ket5,a.ket6,a.ket7,a.ket8,a.ket9,a.ket10,a.ket11,a.ket12,a.ket13,a.ket14,a.ket15,a.ket16,a.ket17,a.ket18,a.ket19,a.ket20,a.ket21")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.id_dcr = b.id_dcr')->get()->getResult();

        $data['pdf'] = $this->db->table("pdf a")->select("a.pdf1,a.pdf2,a.pdf3,a.pdf4,a.pdf5,a.pdf6,a.pdf7,a.pdf8,a.pdf9,a.pdf10")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_dtt')->get();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';

        $data['marketing'] = $this->db->table('master_pkp a')->select("b.nomor,a.no_pkp,a.alias,a.proyek,a.tgl_mulai,a.tgl_selesai,a.nilai_jaminan,a.tgl_jaminan,a.bast_1,a.bast_2,a.referensi,a.id_pkp")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.tgl_ubah_progress >', '2010-01-01')->orderBy('b.nomor')->orderBy('a.no_pkp', 'DESC')->get()->getResult();
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;

        return view('proyek/gedung/gedung1-edit', $data);
    }

    public function edit_2($kode)
    {
        $data['kode'] = '02';
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();

        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;
        $data['tahun'] = substr($tgl, 2, 2);
        $data['bulan'] = substr($tgl, 5, 2);

        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();

        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['dt_umum'] = $this->db->table("dt_umum")->select("*")->where('pkp', $kode)->orderBy('no_urut1', 'ascd')->get()->getResult();

        $data['solusi'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'EKS')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['solusi2'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'INT')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['gambar'] = $this->db->table("gambar a")->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_gbr')->orderBy("a.kode", "desc")->get();

        $data['dcr'] = $this->db->table("dcr a")->select("a.ket1,a.ket2,a.ket3,a.ket4,a.ket5,a.ket6,a.ket7,a.ket8,a.ket9,a.ket10,a.ket11,a.ket12,a.ket13,a.ket14,a.ket15,a.ket16,a.ket17,a.ket18,a.ket19,a.ket20,a.ket21")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.id_dcr = b.id_dcr')->get()->getResult();

        $data['pdf'] = $this->db->table("pdf a")->select("a.pdf1,a.pdf2,a.pdf3,a.pdf4,a.pdf5,a.pdf6,a.pdf7,a.pdf8,a.pdf9,a.pdf10")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_dtt')->orderBy("a.kode", "desc")->get();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;

        return view('proyek/gedung/gedung1-edit2', $data);
    }

    public function edit_3($kode)
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;
        $data['tahun'] = substr($tgl, 2, 2);
        $data['bulan'] = substr($tgl, 5, 2);

        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();

        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['dt_umum'] = $this->db->table("dt_umum")->select("*")->where('pkp', $kode)->orderBy('no_urut1', 'ascd')->get()->getResult();

        $data['solusi'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'EKS')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['solusi2'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'INT')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['gambar'] = $this->db->table("gambar a")->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_gbr')->orderBy("a.kode", "desc")->get();

        $data['dcr'] = $this->db->table("dcr a")->select("a.ket1,a.ket2,a.ket3,a.ket4,a.ket5,a.ket6,a.ket7,a.ket8,a.ket9,a.ket10,a.ket11,a.ket12,a.ket13,a.ket14,a.ket15,a.ket16,a.ket17,a.ket18,a.ket19,a.ket20,a.ket21")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.id_dcr = b.id_dcr')->get()->getResult();

        $data['pdf'] = $this->db->table("pdf a")->select("a.pdf1,a.pdf2,a.pdf3,a.pdf4,a.pdf5,a.pdf6,a.pdf7,a.pdf8,a.pdf9,a.pdf10")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_dtt')->orderBy("a.kode", "desc")->get();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;

        return view('proyek/gedung/gedung1-edit3', $data);
    }
    public function edit_4($kode)
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;
        $data['tahun'] = substr($tgl, 2, 2);
        $data['bulan'] = substr($tgl, 5, 2);

        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();

        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['dt_umum'] = $this->db->table("dt_umum")->select("*")->where('pkp', $kode)->orderBy('no_urut1', 'ascd')->get()->getResult();

        $data['solusi'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'EKS')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['solusi2'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'INT')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['gambar'] = $this->db->table("gambar a")->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_gbr')->orderBy("a.kode", "desc")->get();

        $data['dcr'] = $this->db->table("dcr a")->select("a.ket1,a.ket2,a.ket3,a.ket4,a.ket5,a.ket6,a.ket7,a.ket8,a.ket9,a.ket10,a.ket11,a.ket12,a.ket13,a.ket14,a.ket15,a.ket16,a.ket17,a.ket18,a.ket19,a.ket20,a.ket21")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.id_dcr = b.id_dcr')->get()->getResult();

        $data['pdf'] = $this->db->table("pdf a")->select("a.pdf1,a.pdf2,a.pdf3,a.pdf4,a.pdf5,a.pdf6,a.pdf7,a.pdf8,a.pdf9,a.pdf10")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_dtt')->orderBy("a.kode", "desc")->get();

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;


        return view('proyek/gedung/gedung1-edit4', $data);
    }
    public function edit_5($kode)
    {
        $data['kode'] = '02';
        //dzaki
        date_default_timezone_set("Asia/Jakarta");
        $now = date("Y-m-d");
        $data['now1'] = date("d-m-Y");
        //end-dzaki
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['tgl'] = $data['proyek']->getRow()->tgl_ubah_dcr;
        $data['tahun'] = substr($data['tgl'], 2, 2);
        $data['bulan'] = substr($data['tgl'], 5, 2);
        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;
        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();
        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();
        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();
        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();
        $data['mon_dcr1'] = $this->db->table("mon_dcr")->select("*")->where('type', 'TOTAL')->where('id_pkp', $kode)->where('tgl_import', $data['tgl'])->get()->getResult();
        $data['mon_dcr2'] = $this->db->table("mon_dcr")->select("*")->where('type !=', 'TOTAL')->where('id_pkp', $kode)->get()->getResult();
        $data['mon_dcr1a'] = $this->db->table("mon_dcr")->select("*")->where('type', 'TOTAL')->where('id_pkp', $kode)->get();
        $data['no_pkp'] = $data['proyek']->getRow()->no_pkp;

        // For $db2
        $queryBuilder2 = \Config\Database::connect('qns_dcrv7')->table('dokumen a')
            ->select("d.nama_admin,b.keterangan,b.id_pkp,b.no_pkp,b.alias, MIN(a.tgl_system) as tgl_min, MAX(a.tgl_system) as tgl_max, COUNT(a.id) as total1, sum(if(a.file!='',1,0)) as upload, sum(if((a.tgl_keluar > 0 and a.tgl_keluar > a.tgl_target) or (a.tgl_keluar < 1 and $now > a.tgl_target),1,0)) as telat, sum(if(a.status_dokumen = 'OUT-K' or a.status_dokumen = 'OUT-O' or a.status_dokumen = 'OUT-L',1,0)) as blm_kembali")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->join('master_instansi c', 'b.id_instansi = c.id')
            ->join('master_admin d', 'b.id_admin = d.username', 'left')
            ->where('b.no_pkp', $data['no_pkp']);

        $data['datadcr'] = $queryBuilder2->get()->getResult();

        // For $db3
        $queryBuilder3 = \Config\Database::connect('qns_dcr_ikn')->table('dokumen a')
            ->select("d.nama_admin,b.keterangan,b.id_pkp,b.no_pkp,b.alias, MIN(a.tgl_system) as tgl_min, MAX(a.tgl_system) as tgl_max, COUNT(a.id) as total1, sum(if(a.file!='',1,0)) as upload, sum(if((a.tgl_keluar > 0 and a.tgl_keluar > a.tgl_target) or (a.tgl_keluar < 1 and $now > a.tgl_target),1,0)) as telat, sum(if(a.status_dokumen = 'OUT-K' or a.status_dokumen = 'OUT-O' or a.status_dokumen = 'OUT-L',1,0)) as blm_kembali")
            ->join('master_pkp b', 'a.id_pkp = b.id_pkp')
            ->join('master_instansi c', 'b.id_instansi = c.id')
            ->join('master_admin d', 'b.id_admin = d.username', 'left')
            ->where('b.no_pkp', $data['no_pkp']);

        $data['datadcrikn'] = $queryBuilder3->get()->getResult();



        $data['dcr_ok'] = \Config\Database::connect('qns_dcrv7')->table('dokumen')
            ->select('id_pkp')
            ->where('id_pkp', $kode)
            ->get()
            ->getNumRows();
        // end dzaki - load database 2

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;

        return view('proyek/gedung/gedung1-edit5', $data);
    }
    public function edit_6($kode)
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->table('master_instansi')->get()->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['tgl'] = $data['proyek']->getRow()->tgl_ubah_dcr;
        $data['tahun'] = substr($data['tgl'], 2, 2);
        $data['bulan'] = substr($data['tgl'], 5, 2);

        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $satu = 1;
        $data['akses'] = $this->db->table('rule_akses')->getWhere(['id' => 'RULE1'], 1);
        $QN = $this->db->query("SELECT max(kode) as masKode FROM buka_akses WHERE id_pkp='$kode' and akses='KADIV' and urut='$satu' order by kode");
        $kode_akses = '';
        foreach ($QN->getResult() as $row) {
            $kode_akses = $row->masKode;
        }

        $data['buka_akses2'] = $this->akses->where('kode', $kode_akses)->findAll();

        $QN2 = $this->db->query("SELECT max(kode) as masKode FROM buka_akses WHERE id_pkp='$kode' and akses='KADIRAT' and urut='$satu' order by kode");

        $kode_akses2 = '';
        foreach ($QN2->getResult() as $row2) {
            $kode_akses2 = $row2->masKode;
        }

        $data['buka_akses22'] = $this->akses->where('kode', $kode_akses2)->findAll();

        // Check if $data['buka_akses2'] is not empty before using it
        if (!empty($data['buka_akses2'])) {
            // Access the keterangan property of the first element
            $data['keterangan'] = $data['buka_akses2'][0]->keterangan;
        } else {
            // Handle the case when $data['buka_akses2'] is empty
            $data['keterangan'] = ''; // or any default value
        }


        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['dt_umum'] = $this->db->table("dt_umum")->select("*")->where('pkp', $kode)->orderBy('no_urut1', 'ascd')->get()->getResult();

        $data['solusi'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'EKS')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['solusi2'] = $this->db->table("solusi a")->select("a.nomor,a.type,a.masalah,a.penyebab,a.dampak,a.solusi,a.pic,a.target")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.type', 'INT')->where('a.id_solusi = b.id_solusi')->orderBy('a.nomor', 'ascd')->get()->getResult();

        $data['gambar'] = $this->db->table("gambar a")->select("a.gambar1,a.gambar2,a.gambar3,a.gambar4,a.gambar5")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_gbr')->orderBy("a.kode", "desc")->get();

        $data['dcr'] = $this->db->table("dcr a")->select("a.ket1,a.ket2,a.ket3,a.ket4,a.ket5,a.ket6,a.ket7,a.ket8,a.ket9,a.ket10,a.ket11,a.ket12,a.ket13,a.ket14,a.ket15,a.ket16,a.ket17,a.ket18,a.ket19,a.ket20,a.ket21")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.id_dcr = b.id_dcr')->get()->getResult();

        $data['pdf'] = $this->db->table("pdf a")->select("a.pdf1,a.pdf2,a.pdf3,a.pdf4,a.pdf5,a.pdf6,a.pdf7,a.pdf8,a.pdf9,a.pdf10")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_ubah = b.tgl_ubah_dtt')->orderBy("a.kode", "desc")->get();

        $data['detil_karyawan'] = $this->db->table("detil_karyawan a")->select("b.sisa_cuti,b.tgl_kontrak,a.kode,a.bulan,a.id_pkp,a.pkp_sebelumnya,a.tahun,b.nama_admin,a.id_user,a.sakit,a.ijin,a.alpha,a.cuti,a.ket_absensi,b.jabatan,a.ket_jabatan,a.tgl_ren_mob,a.tgl_ren_demob,a.tgl_real_mob,a.tgl_real_demob,b.habis_kontrak as 'tgl_akhir_kontrak',a.status,a.ket_mobdemob,a.ket_akhir,b.username,d.alias,b.pkp_akhir,b.tgl_respon,a.nama,a.nrp")->join('master_admin b', 'a.nrp = b.username', 'left')->join('master_pkp c', 'a.id_pkp = c.id_pkp')->join('master_pkp d', 'a.pkp_sebelumnya = d.id_pkp', 'left')->where('a.id_pkp', $kode)->where('a.tgl_update = c.tgl_ubah_absensi')->orderBy('a.kode', 'ASCD')->get()->getResult();

        $data['detil_karyawan3'] = $this->db->table("detil_karyawan a")->select("a.kode,a.bulan,a.id_pkp,a.pkp_sebelumnya,a.tahun,b.nama_admin,a.id_user,a.sakit,a.ijin,a.alpha,a.cuti,a.ket_absensi,b.jabatan,a.ket_jabatan,a.tgl_ren_mob,a.tgl_ren_demob,a.tgl_real_mob,a.tgl_real_demob,b.habis_kontrak as 'tgl_akhir_kontrak',a.status,a.ket_mobdemob,a.ket_akhir,b.username,d.alias,b.pkp_akhir")->join('master_admin b', 'a.nrp = b.username', 'left')->join('master_pkp c', 'a.id_pkp = c.id_pkp')->join('master_pkp d', 'a.pkp_sebelumnya = d.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_update = c.tgl_ubah_absensi')->orderBy('a.kode', 'ASCD')->get();

        if ($data['detil_karyawan3']->getNumRows() > 0) {
            $data['detil_karyawan2'] = $this->db->table("detil_karyawan a")->select("a.bulan,a.tahun,b.nama_admin,a.id_user,a.sakit,a.ijin,a.alpha,a.cuti,a.ket_absensi,a.jabatan,a.ket_jabatan,a.tgl_ren_mob,a.tgl_ren_demob,a.tgl_real_mob,a.tgl_real_demob,a.tgl_akhir_kontrak,a.status,a.ket_mobdemob,a.ket_akhir,a.nrp")->join('master_admin b', 'a.nrp = b.username', 'left')->join('master_pkp c', 'a.id_pkp = c.id_pkp')->where('a.id_pkp', $kode)->where('a.tgl_update = c.tgl_ubah_absensi')->get()->getResultArray();
            $result2 = array_column($data['detil_karyawan2'], 'nrp');

            $data['detil_no_list'] = $this->db->table('master_admin')->select("*")->orWhereNotIn('username', $result2)->where('pkp_akhir', $kode)->where('aktif', '1')->get()->getResult();
        } else {
            $data['detil_no_list'] = $this->db->table('master_admin')->select("*")->where('pkp_akhir', $kode)->where('aktif', '1')->get()->getResult();
        }

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;

        return view('proyek/gedung/gedung1-edit6', $data);
    }

    public function edit_7($kode)
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['instansi'] = $this->db->get('master_instansi')->getResult();
        $data['breadcumb'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $data['divisi'] = $this->db->table("master_pkp a")->select("b.alias")->join('master_instansi b', 'a.id_instansi = b.id')->getWhere(['id_pkp' => $kode], 1);
        $data['proyek'] = $this->db->table('master_pkp')->db->getWhere(['id_pkp' => $kode], 1);
        $data['tgl'] = $data['proyek']->getRow()->tgl_ubah_inventaris;
        $data['tahun'] = substr($data['tgl'], 2, 2);
        $data['bulan'] = substr($data['tgl'], 5, 2);

        $data['instansiQN'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();
        $data['nomorQN'] = $data['instansiQN']->getRow()->nomor;

        $data['instansi2'] = $this->db->table("master_pkp a")->select("b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get()->getResult();
        $data['instansi3'] = $this->db->table("master_pkp a")->select("b.nomor,b.alias,b.ling")->join('master_instansi b', 'a.id_instansi = b.id')->where('a.id_pkp', $kode)->get();

        $data['paket'] = $this->db->table("progress_paket a")->select("a.kode_pt,b.proyek,a.paket,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,d.alias")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->join('pt_detil c', 'a.id_pt = c.id', 'left')->join('pt_master d', 'c.id_pt = d.id', 'left')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->orderBy("a.nomor", "ascd")->get()->getResult();

        $data['proyek2'] = $this->db->table("progress_proyek a")->select("b.proyek,a.id_pkp,a.bobot_pg,a.rensd_mgll,a.rilsd_mgll,a.devsd_mgll,a.ren_mgini,a.ril_mgini,a.dev_mgini,a.rensd_mgini,a.rilsd_mgini,a.devsd_mgini,a.sisa_bobotpg,a.tgl_mulai,a.tgl_selesai,a.sisa_waktu,a.target_minggu,a.tgl_ubah_progress")->join('master_pkp b', 'a.id_pkp = b.id_pkp')->where('a.id_pkp', $kode)->where('a.tahun', $data['tahun'])->where('a.bulan', $data['bulan'])->get()->getResult();

        $data['cek_pro'] = $this->db->table("progress_proyek")->where('id_pkp', $kode, 1)->get();

        $data['cek2'] = $this->db->table("dt_umum")->where('pkp', $kode, 1)->get();

        $data['invent1'] = $this->proyek->getInvent1($kode);

        $data['invent2'] = $this->proyek->getInvent2($kode);

        $data['invent3'] = $this->proyek->getInvent3($kode);

        $data['gambar'] = $this->proyek->getGambar($kode);

        $data['judul'] = '<a href="' . base_url() . 'proyek" style="color:white">PROYEK | </a><a style="color:white">' . $data['proyek']->getRow()->alias . ' | </a> <a href="' . base_url() . $data['instansi3']->getRow()->ling . '" style="color:white">' . $data['instansi3']->getRow()->alias . '</a>';

        return view('proyek/gedung/gedung1-edit7', $data);
    }



    public function proses_upload_solusi()
    {
        $nama_file = csrf_hash();
        $originalFileName = $this->request->getFile('excelfile')->getName();
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        $nama_file = csrf_hash() . '.' . $extension;

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

        $arraysub = [];
        if ($aksi['result'] == 'success') {
            $spreadsheet = IOFactory::load('excel/' . $nama_file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(
                true,
                true,
                true,
                true,
                true
            );
            $data = [];
            $baris = 1;
            //THBL TGL BERJALAN//
            date_default_timezone_set("Asia/Jakarta");
            $now = date("Y-m-d");
            $post = $this->request->getPost();
            $id_pkp58 = $post['id_pkp58'];
            //HAPUS DATA TANGGAL HARI INI
            $QN01 = $this->db->query("SELECT * FROM solusi where tgl_ubah='$now' and id_pkp='$id_pkp58'");
            if ($QN01->getNumRows() > 0) {
                $this->db->table('solusi')->where('tgl_ubah', $now)
                    ->where('id_pkp', $id_pkp58)
                    ->delete();
            }
            //ambil no urut terakhir//
            //INSTHBL-12345//
            //KODE-SOLUSI BERSAMA//
            $QN3 = $this->db->query("SELECT max(id_solusi) as masKode3 FROM master_pkp order by id_solusi");
            foreach ($QN3->getResult() as $row3) {
                $order3 = $row3->masKode3;
            }
            $noUrut3 = (int) substr($order3, 8, 5);
            $noUrut3++;
            //BL masKode//
            $bulanL3 = substr($order3, 5, 2);
            $bln3 = substr($now, 5, 2);
            $tahun3 = substr($now, 2, 2);
            if ($bln3 == $bulanL3) {
                $kode3 = 'IDS' . $tahun3 . $bln3 . '-' . sprintf("%05s", $noUrut3);
            } else {
                $kode3 = 'IDS' . $tahun3 . $bln3 . '-' . '00001';
            }


            $data0 = [
                'tgl_ubah_masalah' => $now,
                'id_solusi' => $kode3,
            ];
            $this->db->table('master_pkp')->where('id_pkp', $id_pkp58)->update($data0);
            //ambil no urut terakhir//
            //INSTHBL-12345//
            $QN = $this->db->query("SELECT max(kode) as masKode FROM solusi order by kode");
            foreach ($QN->getResult() as $row2) {
                $order = $row2->masKode;
            }
            $noUrut = (int) substr($order, 8, 5);
            $noUrut++;
            //BL masKode//
            $bulanL = substr($order, 5, 2);
            $bln = substr($now, 5, 2);
            $tahun = substr($now, 2, 2);
            if ($bln == $bulanL) {
                $kode = 'SOL' . $tahun . $bln . '-' . sprintf("%05s", $noUrut);
            } else {
                $kode = 'SOL' . $tahun . $bln . '-' . '00001';
            }
            $id1 = 'SOL' . md5($kode);
            $id2 = 'SOL' . hash("sha1", $id1) . 'QNS';
            $idQNS = session('idadmin');
            $no = -1;
            foreach ($sheetData as $row) {
                if ($baris > 2) {

                    $C = $row['C'];
                    $D = $row['D'];
                    $E = $row['E'];
                    $F = $row['F'];
                    $G = $row['G'];
                    $H = $row['H'];
                    $I = $row['I'];

                    if ($C == '1') {
                        $C = '';
                    }
                    if ($D == '1') {
                        $D = '';
                    }
                    if ($E == '1') {
                        $E = '';
                    }
                    if ($F == '1') {
                        $F = '';
                    }
                    if ($G == '1') {
                        $G = '';
                    }
                    if ($H == '1') {
                        $H = '';
                    }
                    if ($I == '1') {
                        $I = '';
                    }

                    array_push($data, [
                        'id' => $id2,
                        'kode' => $kode,
                        'id_pkp' => $id_pkp58,
                        'id_solusi' => $kode3,
                        'tgl_ubah' => $now,
                        'id_ubah' => $idQNS,

                        'nomor' => $no,
                        'type' => $C,
                        'masalah' => $D,
                        'penyebab' => $E,
                        'dampak' => $F,
                        'solusi' => $G,
                        'pic' => $H,
                        'target' => $I,
                    ]);
                }
                $baris++;
                $noUrut++;
                $no++;
                $kode = 'SOL' . $tahun . $bln . '-' . sprintf("%05s", $noUrut);
                $id1 = 'SOL' . md5($kode);
                $id2 = 'SOL' . hash("sha1", $id1) . 'QNS';
            }
            if ($this->proyek->input_semua3b($data)) {
                $this->session->setFlashdata('success', 'upload solusi sukses');
                $redirectUrl = previous_url() ?? base_url();
            } else {
                $this->session->setFlashdata('gagal', 'mengupload semua data, pastikan data yang diinput benar');
                $redirectUrl = previous_url() ?? base_url();
            }

            $data['id_pkp'] = $id_pkp58;
            $data['token'] = csrf_hash();
            return redirect()->to($redirectUrl);
        }
    }

    public function xls1($kode)
    {
        date_default_timezone_set("Asia/Jakarta");
        $now = date("Y-m-d");
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;

        $data['22'] = $this->db->table('progress_proyek')->orderBy('kode', 'desc')->getWhere(['id_pkp' => $kode, 'tgl_ubah_progress' => $tgl]);
        if ($data['22']->getNumRows() > 0) {
            $tahun22 = $data['22']->getRow()->tahun;
            $bulan22 = $data['22']->getRow()->bulan;
        } else {
            $bulan22 = substr($now, 5, 2);
            $tahun22 = substr($now, 2, 2);
            //$tahun22 = '';
            //$bulan22 = '';
        }

        // Panggil class PHPExcel nya
        $excel = new Spreadsheet();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
            ), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN,
                    'color' => array('rgb' => 'FFFFFF'),
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => '535454'),
            )
        );
        $style_subjudul = array(
            // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
                'vertical' => Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'FFFFFF'),
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'E8AC52'),
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array('style' => Border::BORDER_THIN), // Set border top dengan garis tipis

            )
        );
        $style_left = array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara vertical (middle)
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "LAPORAN PROGRESS, Proyek: " . $data['proyek']->getRow()->alias);
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "BULAN : ");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $bulan22);
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "TAHUN : ");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', '20' . $tahun22);

        $excel->getActiveSheet()->getStyle('C3:C4')->applyFromArray($style_left);

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "PAKET PEKERJAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('C5', "KONTRAKTOR");
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "BOBOT");

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "S/D BULAN LALU");
        $excel->setActiveSheetIndex(0)->setCellValue('E6', "Plan");
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "Actual");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "Deviasi");

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "BULAN INI");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "Plan");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "Actual");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "Deviasi");

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "S/D BULAN INI");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "Plan");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "Actual");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "Deviasi");

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "Waktu Pelaksanaan");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "Start");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "Finis");

        $excel->setActiveSheetIndex(0)->setCellValue('P5', "Target /Bulan");

        $excel->setActiveSheetIndex(0)->setCellValue('Q5', "Adendum");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "Start");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "Finish");

        $excel->setActiveSheetIndex(0)->setCellValue('S5', "Tanggal Real Selesai");
        $excel->setActiveSheetIndex(0)->setCellValue('T5', "Keterangan");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('B5:T6')->applyFromArray($style_col);

        $excel->getActiveSheet()->mergeCells('B5:B6');
        $excel->getActiveSheet()->mergeCells('C5:C6');
        $excel->getActiveSheet()->mergeCells('D5:D6');
        $excel->getActiveSheet()->mergeCells('E5:G5');
        $excel->getActiveSheet()->mergeCells('H5:J5');
        $excel->getActiveSheet()->mergeCells('K5:M5');
        $excel->getActiveSheet()->mergeCells('N5:O5');
        $excel->getActiveSheet()->mergeCells('P5:P6');
        $excel->getActiveSheet()->mergeCells('Q5:R5');
        $excel->getActiveSheet()->mergeCells('S5:S6');
        $excel->getActiveSheet()->mergeCells('T5:T6');


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 3

        $QN4 = $this->db->query("SELECT * FROM progress_paket where id_pkp='$kode' and tahun='$tahun22' and bulan='$bulan22' order by kode");
        if ($QN4->getNumRows() > 0) {
            foreach ($QN4->getResult() as $data) {
                if ($data->tgl_mulai > 0) {
                    $tgl_mulai = $data->tgl_mulai;
                } else {
                    $tgl_mulai = '';
                }
                if ($data->tgl_selesai > 0) {
                    $tgl_selesai = $data->tgl_selesai;
                } else {
                    $tgl_selesai = '';
                }
                if ($data->tgl_sadd > 0) {
                    $tgl_sadd = $data->tgl_sadd;
                } else {
                    $tgl_sadd = '';
                }
                if ($data->tgl_fadd > 0) {
                    $tgl_fadd = $data->tgl_fadd;
                } else {
                    $tgl_fadd = '';
                }
                if ($data->tgl_rf > 0) {
                    $tgl_rf = $data->tgl_rf;
                } else {
                    $tgl_rf = '';
                }
                //$excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'O' . $numrow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->paket);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->kode_pt);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, number_format($data->bobot_pg, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, number_format($data->rensd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, number_format($data->rilsd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, number_format($data->devsd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, number_format($data->ren_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, number_format($data->ril_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, number_format($data->dev_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, number_format($data->rensd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, number_format($data->rilsd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, number_format($data->devsd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $tgl_mulai);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $tgl_selesai);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, number_format($data->target_minggu, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $tgl_sadd);
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $tgl_fadd);
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $tgl_rf);
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->keterangan);

                $excel->getActiveSheet()->getStyle('B' . $numrow . ':T' . $numrow)->applyFromArray($style_row);
                //$excel->getActiveSheet()->getStyle('B' . $numrow . ':P' . $numrow)->getAlignment()->setWrapText(true);
                //$excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'P' . $numrow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Isi Nama Paket');
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, 'Isi Nama Singkat Kontraktor');
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, 100);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 20.5);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, 17.5);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, -2.5);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, 5);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, 6);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, 1);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 25.5);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 23.5);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, -2);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '2022-01-01');
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '2023-01-01');
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 6.29);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, '');

            $excel->getActiveSheet()->getStyle('B' . $numrow . ':T' . $numrow)->applyFromArray($style_row);
            //$excel->getActiveSheet()->getStyle('B' . $numrow . ':P' . $numrow)->getAlignment()->setWrapText(true);
            //$excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'P' . $numrow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $no++; // Tambah 1 setiap kali looping
            $numrow++;
        }
        $QN5 = $this->db->query("SELECT * FROM progress_proyek where id_pkp='$kode' and tahun='$tahun22' and bulan='$bulan22' order by kode");
        if ($QN5->getNumRows() > 0) {
            foreach ($QN5->getResult() as $data2) {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'TOTAL');
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, '-');
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, number_format($data2->bobot_pg, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, number_format($data2->rensd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, number_format($data2->rilsd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, number_format($data2->devsd_mgll, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, number_format($data2->ren_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, number_format($data2->ril_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, number_format($data2->dev_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, number_format($data2->rensd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, number_format($data2->rilsd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, number_format($data2->devsd_mgini, 2, '.', ','));
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, '');
                $excel->getActiveSheet()->getStyle('B' . $numrow . ':T' . $numrow)->applyFromArray($style_row);
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'TOTAL');
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, 100);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 20.5);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, 17.5);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, -2.5);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, 5);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, 6);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, 1);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 25.5);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 23.5);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, -2);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, '');
            $excel->getActiveSheet()->getStyle('B' . $numrow . ':T' . $numrow)->applyFromArray($style_row);
        }
        // Set width kolom

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(1); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data Progress");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataProgress.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
    }

    public function pdf1($kode)
    {
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_progress;
        $tahun = substr($tgl, 2, 2);
        $bulan = substr($tgl, 5, 2);


        $no = 1;
        $fpdf = new FPDF('L', 'mm', 'A3');
        global $title;
        $fpdf->SetTitle($title);
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Ln();
        $fpdf->Cell(50, 1, 'DATA PROGRESS', 0, 0, 'L');
        $fpdf->Ln(8);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(10, 5, 'NO', 'LTR', 0, 'C', 0);
        $fpdf->Cell(80, 5, 'NAMA PAKET', 'LTR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'BOBOT', 'LTR', 0, 'C', 0);
        $fpdf->Cell(60, 5, 'S/D BULAN LALU', 'LTR', 0, 'C', 0);
        $fpdf->Cell(60, 5, 'BULAN INI', 'LTR', 0, 'C', 0);
        $fpdf->Cell(60, 5, 'S/D BULAN INI', 'LTR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'SISA', 'LTR', 0, 'C', 0);
        $fpdf->Cell(50, 5, 'WAKTU PELAKSANAAN', 'LTR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'SISA', 'LTR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'TARGET/', 'LTR', 1, 'C', 0);
        $fpdf->Cell(10, 5, '', 'LBR', 0, 'C', 0);
        $fpdf->Cell(80, 5, '', 'LBR', 0, 'C', 0);
        $fpdf->Cell(20, 5, '', 'LBR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'PLAN', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'ACTUAL', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'DEVIASI', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'PLAN', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'ACTUAL', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'DEVIASI', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'PLAN', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'ACTUAL', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'DEVIASI', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'PROGRES', 'LBR', 0, 'C', 0);
        $fpdf->Cell(25, 5, 'TGL MULAI', 1, 0, 'C', 0);
        $fpdf->Cell(25, 5, 'TGL SELESAI', 1, 0, 'C', 0);
        $fpdf->Cell(20, 5, 'WAKTU', 'LBR', 0, 'C', 0);
        $fpdf->Cell(20, 5, 'BULAN', 'LBR', 1, 'C', 0);

        $no = 1;
        $builder = $this->db->table('progress_paket');
        $builder->select('*');
        $builder->where('id_pkp', $kode);
        $builder->where('tahun', $tahun);
        $builder->where('bulan', $bulan);
        $builder->orderBy('kode');

        $QN4 = $builder->get()->getResult();

        foreach ($QN4 as $data) {
            $fpdf->SetFont('Arial', '', 9);
            $fpdf->Cell(10, 5, $no, 1, 0, 'C', 0);
            $fpdf->Cell(80, 5, $data->paket, 1, 0, 'L', 0);
            $fpdf->Cell(20, 5, number_format($data->bobot_pg, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->rensd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->rilsd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->devsd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->ren_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->ril_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->dev_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->rensd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->rilsd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->devsd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->sisa_bobotpg, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(25, 5, $data->tgl_mulai, 1, 0, 'C', 0);
            $fpdf->Cell(25, 5, $data->tgl_selesai, 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, $data->sisa_waktu, 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data->target_minggu, 2, ',', '.'), 1, 1, 'C', 0);
            $no++;
        }
        $builder2 = $this->db->table('progress_proyek');
        $builder2->select('*');
        $builder2->where('id_pkp', $kode);
        $builder2->where('tahun', $tahun);
        $builder2->where('bulan', $bulan);
        $builder2->orderBy('kode');

        $QN5 = $builder2->get()->getResult();

        foreach ($QN5 as $data2) {
            $fpdf->SetFont('Arial', '', 9);
            $fpdf->Cell(90, 5, 'TOTAL', 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->bobot_pg, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->rensd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->rilsd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->devsd_mgll, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->ren_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->ril_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->dev_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->rensd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->rilsd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->devsd_mgini, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, number_format($data2->sisa_bobotpg, 2, ',', '.'), 1, 0, 'C', 0);
            $fpdf->Cell(25, 5, '', 1, 0, 'C', 0);
            $fpdf->Cell(25, 5, '', 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, '', 1, 0, 'C', 0);
            $fpdf->Cell(20, 5, '', 1, 1, 'C', 0);
        }

        $this->response->setContentType('application/pdf');
        $fpdf->Output('I', 'report.pdf');
    }

    public function pdf2($kode)
    {
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_absensi;
        $bln_lalu = date('m', strtotime('-1 month', strtotime($tgl)));
        $thn_lalu = date('Y', strtotime('-1 month', strtotime($tgl)));

        //Cari periode

        if ($bln_lalu == '01') {
            $bulan = 'Januari';
        } else {
            if ($bln_lalu == '02') {
                $bulan = 'Februari';
            } else {
                if ($bln_lalu == '03') {
                    $bulan = 'Maret';
                } else {
                    if ($bln_lalu == '04') {
                        $bulan = 'April';
                    } else {
                        if ($bln_lalu == '05') {
                            $bulan = 'Mei';
                        } else {
                            if ($bln_lalu == '06') {
                                $bulan = 'Juni';
                            } else {
                                if ($bln_lalu == '07') {
                                    $bulan = 'Juli';
                                } else {
                                    if ($bln_lalu == '08') {
                                        $bulan = 'Agustus';
                                    } else {
                                        if ($bln_lalu == '09') {
                                            $bulan = 'September';
                                        } else {
                                            if ($bln_lalu == '10') {
                                                $bulan = 'Oktober';
                                            } else {
                                                if ($bln_lalu == '11') {
                                                    $bulan = 'November';
                                                } else {
                                                    $bulan = 'Desember';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $no = 1;
        $fpdf = new FPDF('L', 'mm', 'A3');
        global $title;
        $fpdf->SetTitle($title);
        $fpdf->SetLeftMargin(2);
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', '', 6);
        $fpdf->Ln();
        $fpdf->Cell(1, 2, 'LAPORAN MOBILISASI/ DEMOBILISASI, ABSENSI DAN AKHIR KONTRAK KARYAWAN', 0, 0, 'L');
        $fpdf->Ln();
        $fpdf->Cell(1, 2, 'PROYEK  : ' . $data['proyek']->getRow()->alias, 0, 0, 'L');
        $fpdf->Ln();
        $fpdf->Cell(1, 2, 'PERIODE : ' . $bulan . ' ' . $thn_lalu, 0, 0, 'L');
        $fpdf->Ln(3);
        $fpdf->SetFont('Arial', '', 5);
        $fpdf->SetFillColor(220, 220, 220);
        $fpdf->Cell(5, 10, 'NO', 'LRT', 0, 'C', true);
        $fpdf->Cell(10, 10, 'NRP', 'LRT', 0, 'C', true);
        $fpdf->Cell(30, 10, 'NAMA KARYAWAN', 'LRT', 0, 'C', true);
        $fpdf->Cell(28, 5, 'ABSENSI', 1, 0, 'C', true);
        $fpdf->Cell(25, 10, 'KET.ABSENSI', 'LRT', 0, 'C', true);
        $fpdf->Cell(20, 10, 'JABATAN', 'LRT', 0, 'C', true);
        $fpdf->Cell(20, 10, 'KET.JABATAN', 'LRT', 0, 'C', true);
        $fpdf->Cell(20, 5, 'TGL AKHIR', 'LRT', 0, 'C', true);
        $fpdf->Cell(34, 5, 'MOBILISASI', 1, 0, 'C', true);
        $fpdf->Cell(34, 5, 'DEMOBILISASI', 1, 0, 'C', true);
        $fpdf->Cell(20, 10, 'STATUS', 'LRT', 0, 'C', true);
        $fpdf->Cell(25, 5, 'KETERANGAN', 'LRT', 0, 'C', true);
        $fpdf->Cell(20, 10, 'MUTASI/RESIGN', 'LRT', 0, 'C', true);
        $fpdf->Cell(1, 5, '', 0, 1, 'C');
        $fpdf->Cell(5, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(10, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(30, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(7, 5, 'Sakit', 1, 0, 'C', true);
        $fpdf->Cell(7, 5, 'Ijin', 1, 0, 'C', true);
        $fpdf->Cell(7, 5, 'Alpha', 1, 0, 'C', true);
        $fpdf->Cell(7, 5, 'Cuti', 1, 0, 'C', true);
        $fpdf->Cell(25, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(20, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(20, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(20, 5, 'KONTRAK', 'LRB', 0, 'C', true);
        $fpdf->Cell(17, 5, 'Rencana', 1, 0, 'C', true);
        $fpdf->Cell(17, 5, 'Aktual', 1, 0, 'C', true);
        $fpdf->Cell(17, 5, 'Rencana', 1, 0, 'C', true);
        $fpdf->Cell(17, 5, 'Aktual', 1, 0, 'C', true);
        $fpdf->Cell(20, 5, '', 'LRB', 0, 'C');
        $fpdf->Cell(25, 5, 'MOB/DEMOB', 'LRB', 0, 'C', true);
        $fpdf->Cell(20, 5, '', 'LRB', 1, 'C');
        $fpdf->Ln(0);
        //isi absensi
        $QN01 = $this->db->query("SELECT * FROM detil_karyawan where id_pkp='$kode' and tgl_update='$tgl' order by kode");
        if ($QN01->getNumRows() > 0) {
            $no01 = 1;
            foreach ($QN01->getResult() as $data01) {
                $user = $this->db->table("master_admin")->where('id', $data01->id_user, 1)->get()->getRow();
                if ($data01->sakit > 0) {
                    $sakit = $data01->sakit;
                } else {
                    $sakit = '';
                }
                if ($data01->ijin > 0) {
                    $ijin = $data01->ijin;
                } else {
                    $ijin = '';
                }
                if ($data01->alpha > 0) {
                    $alpha = $data01->alpha;
                } else {
                    $alpha = '';
                }
                if ($data01->cuti > 0) {
                    $cuti = $data01->cuti;
                } else {
                    $cuti = '';
                }
                if ($data01->tgl_akhir_kontrak > 0) {
                    $tgl_akhir_kontrak = date('d-m-Y', strtotime($data01->tgl_akhir_kontrak));
                } else {
                    $tgl_akhir_kontrak = '';
                }
                if ($data01->tgl_ren_mob > 0) {
                    $tgl_ren_mob = date('d-m-Y', strtotime($data01->tgl_ren_mob));
                } else {
                    $tgl_ren_mob = '';
                }
                if ($data01->tgl_real_mob > 0) {
                    $tgl_real_mob = date('d-m-Y', strtotime($data01->tgl_real_mob));
                } else {
                    $tgl_real_mob = '';
                }
                if ($data01->tgl_ren_demob > 0) {
                    $tgl_ren_demob = date('d-m-Y', strtotime($data01->tgl_ren_demob));
                } else {
                    $tgl_ren_demob = '';
                }
                if ($data01->tgl_real_demob > 0) {
                    $tgl_real_demob = date('d-m-Y', strtotime($data01->tgl_real_demob));
                } else {
                    $tgl_real_demob = '';
                }
                $fpdf->Cell(5, 5, $no01, 1, 0, 'R');
                $fpdf->Cell(10, 5, $user->username, 1, 0, 'C');
                $fpdf->Cell(30, 5, $user->nama_admin, 1, 0, 'L');
                $fpdf->Cell(7, 5, $sakit, 1, 0, 'C');
                $fpdf->Cell(7, 5, $ijin, 1, 0, 'C');
                $fpdf->Cell(7, 5, $alpha, 1, 0, 'C');
                $fpdf->Cell(7, 5, $cuti, 1, 0, 'C');
                $fpdf->Cell(25, 5, $data01->ket_absensi, 1, 0, 'C');
                $fpdf->Cell(20, 5, $data01->jabatan, 1, 0, 'L');
                $fpdf->Cell(20, 5, $data01->ket_jabatan, 1, 0, 'C');
                $fpdf->Cell(20, 5, $tgl_akhir_kontrak, 1, 0, 'C');
                $fpdf->Cell(17, 5, $tgl_ren_mob, 1, 0, 'C');
                $fpdf->Cell(17, 5, $tgl_real_mob, 1, 0, 'C');
                $fpdf->Cell(17, 5, $tgl_ren_demob, 1, 0, 'C');
                $fpdf->Cell(17, 5, $tgl_real_demob, 1, 0, 'C');
                $fpdf->Cell(20, 5, $data01->status, 1, 0, 'C');
                $fpdf->Cell(25, 5, $data01->ket_mobdemob, 1, 0, 'C');
                $fpdf->Cell(20, 5, $data01->ket_akhir, 1, 1, 'C');
                $no01++;
            }
        }
        $this->response->setContentType('application/pdf');
        $fpdf->Output('I', 'report.pdf');

    }

    public function upd_close_pkp()
    {
        $post = $this->request->getPost();
        $postData = [
            'id_pkp' => $this->request->getPost('id_pkp'),
            'tgl_close' => $this->request->getPost('tgl_close')
        ];
        $simpan = $this->proyek;
        if ($simpan->simpantglclose($postData)) {
            $this->session->setFlashdata('success', 'update data');
            $redirectUrl = previous_url() ?? base_url();
        } else {
            $this->session->setFlashdata('error', 'update data');
            $redirectUrl = previous_url() ?? base_url();
        }
        $data['id_pkp'] = $postData['id_pkp'];
        $data['token'] = csrf_hash();
        return redirect()->to($redirectUrl);
    }

    public function xls2($kode)
    {
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_masalah;
        $tahun = substr($tgl, 2, 2);
        $bulan = substr($tgl, 5, 2);

        // Panggil class PHPExcel nya
        $excel = new Spreadsheet();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data")
            ->setSubject("")
            ->setDescription("Laporan Semua Data")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
            ), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN,
                    'color' => array('rgb' => 'FFFFFF'),
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => '535454'),
            )
        );
        $style_subjudul = array(
            // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
                'vertical' => Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN,
                    // 'color' => array('rgb' => 'FFFFFF'),
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'E8AC52'),
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array('style' => Border::BORDER_THIN), // Set border top dengan garis tipis

            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('B2', "LAPORAN PERMASALAHAN POKOK"); // Set kolom A1 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "PROYEK : " . $data['proyek']->getRow()->alias); // Set kolom B1 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('B5', "NO"); // Set kolom C1 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('C5', "URAIAN"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "PENYEBAB");
        $excel->setActiveSheetIndex(0)->setCellValue('E5', "DAMPAK");
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "TINDAK LANJUT/SOLUSI");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', "NAMA PIC"); // Set kolom E1 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('H5', "TARGET");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('B5:H5')->applyFromArray($style_col);
        $QN01 = $this->db->query("SELECT * FROM solusi where id_pkp='$kode' and tgl_ubah='$tgl' and type='EKS' order by kode");
        $baris = 6;
        if ($QN01->getNumRows() > 0) {
            $no01 = 1;
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, 'EKSTERNAL');
            $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->applyFromArray($style_subjudul);
            $excel->getActiveSheet()->mergeCells('B' . $baris . ':H' . $baris);
            $baris++;
            foreach ($QN01->getResult() as $data01) {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, $no01);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $baris, $data01->masalah);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $baris, $data01->penyebab);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $baris, $data01->dampak);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $baris, $data01->solusi);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $baris, $data01->pic);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $baris, $data01->target);
                $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->getAlignment()->setWrapText(true);
                $no01++;
                $baris++;
            }
        }
        // Set width kolom
        $QN01 = $this->db->query("SELECT * FROM solusi where id_pkp='$kode' and tgl_ubah='$tgl' and type='INT' order by kode");
        if ($QN01->getNumRows() > 0) {
            $no01 = 1;
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, 'INTERNAL');
            $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->applyFromArray($style_subjudul);
            $excel->getActiveSheet()->mergeCells('B' . $baris . ':H' . $baris);
            $baris++;
            foreach ($QN01->getResult() as $data01) {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, $no01);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $baris, $data01->masalah);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $baris, $data01->penyebab);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $baris, $data01->dampak);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $baris, $data01->solusi);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $baris, $data01->pic);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $baris, $data01->target);
                $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $baris . ':H' . $baris)->getAlignment()->setWrapText(true);
                $no01++;
                $baris++;
            }
        }
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(35); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nyap
        $excel->getActiveSheet(0)->setTitle("Masalah Pokok");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataMasalah.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
    }

    public function xls3($kode)
    {
        $data['proyek'] = $this->db->table('master_pkp')->getWhere(['id_pkp' => $kode], 1);
        $tgl = $data['proyek']->getRow()->tgl_ubah_absensi;
        $tahun = substr($tgl, 2, 2);
        $bulan = substr($tgl, 5, 2);


        // Panggil class PHPExcel nya
        $excel = new Spreadsheet();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data ")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
            ), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN,
                    'color' => array('rgb' => 'FFFFFF'),
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => '535454'),
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'allborders' => array('style' => Border::BORDER_THIN), // Set border top dengan garis tipis

            )
        );
        //Cari periode
        $QN00 = $this->db->query("SELECT * FROM detil_karyawan where id_pkp='$kode' and tgl_update='$tgl' order by kode");
        foreach ($QN00->getResult() as $row00) {
            $tahun = $row00->tahun;
            if ($row00->bulan = '01') {
                $bulan = 'Januari';
            } else {
                if ($row00->bulan = '02') {
                    $bulan = 'Februari';
                } else {
                    if ($row00->bulan = '03') {
                        $bulan = 'Maret';
                    } else {
                        if ($row00->bulan = '04') {
                            $bulan = 'April';
                        } else {
                            if ($row00->bulan = '05') {
                                $bulan = 'Mei';
                            } else {
                                if ($row00->bulan = '06') {
                                    $bulan = 'Juni';
                                } else {
                                    if ($row00->bulan = '07') {
                                        $bulan = 'Juli';
                                    } else {
                                        if ($row00->bulan = '08') {
                                            $bulan = 'Agustus';
                                        } else {
                                            if ($row00->bulan = '09') {
                                                $bulan = 'September';
                                            } else {
                                                if ($row00->bulan = '10') {
                                                    $bulan = 'Oktober';
                                                } else {
                                                    if ($row00->bulan = '11') {
                                                        $bulan = 'November';
                                                    } else {
                                                        $bulan = 'Desember';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //JUDUL
        $excel->setActiveSheetIndex(0)->setCellValue('B2', "LAPORAN MOBILISASI/ DEMOBILISASI, ABSENSI DAN AKHIR KONTRAK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "PROYEK : " . $data['proyek']->getRow()->alias);
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE : " . $bulan . ' ' . $tahun);
        //HEADER
        $excel->setActiveSheetIndex(0)->setCellValue('B5', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('C5', "NRP");
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "NAMA KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('E5', "ABSENSI");
        $excel->setActiveSheetIndex(0)->setCellValue('E6', "Sakit");
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "Ijin");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "Alpha");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "Cuti");
        $excel->setActiveSheetIndex(0)->setCellValue('I5', "KET. ABSENSI");
        $excel->setActiveSheetIndex(0)->setCellValue('J5', "JABATAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K5', "POSISI");
        $excel->setActiveSheetIndex(0)->setCellValue('L5', "KONTRAK");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TGL AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TGL AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('N5', "MOB");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "Renc");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "Real");
        $excel->setActiveSheetIndex(0)->setCellValue('P5', "DEMOB");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "Renc");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "Real");
        $excel->setActiveSheetIndex(0)->setCellValue('R5', "STATUS");
        $excel->setActiveSheetIndex(0)->setCellValue('S5', "Ket. MOB/DEMOB");
        $excel->setActiveSheetIndex(0)->setCellValue('T5', "MUTASI/ RESIGN/TF");

        //MERGE HEADER
        $excel->getActiveSheet()->mergeCells('B5:B6');
        $excel->getActiveSheet()->mergeCells('C5:C6');
        $excel->getActiveSheet()->mergeCells('D5:D6');
        $excel->getActiveSheet()->mergeCells('E5:H5');
        $excel->getActiveSheet()->mergeCells('I5:I6');
        $excel->getActiveSheet()->mergeCells('J5:J6');
        $excel->getActiveSheet()->mergeCells('K5:K6');
        $excel->getActiveSheet()->mergeCells('L5:M5');
        $excel->getActiveSheet()->mergeCells('N5:O5');
        $excel->getActiveSheet()->mergeCells('P5:Q5');
        $excel->getActiveSheet()->mergeCells('R5:R6');
        $excel->getActiveSheet()->mergeCells('S5:S6');
        $excel->getActiveSheet()->mergeCells('T5:T6');
        //STYLE HEADER
        $excel->getActiveSheet()->getStyle('B5:T6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5:T6')->getAlignment()->setWrapText(true);

        //isi absensi
        $QN01 = $this->db->query("SELECT * FROM detil_karyawan where id_pkp='$kode' and tgl_update='$tgl' order by kode");
        $baris = 7;
        if ($QN01->getNumRows() > 0) {
            $no01 = 1;
            foreach ($QN01->getResult() as $data01) {
                $id_user = $data01->id_user;
                $QN02 = $this->db->query("SELECT * FROM master_admin where id='$id_user'");
                if ($QN02->getNumRows() > 0) {
                    foreach ($QN02->getResult() as $data02) {
                        $nama = $data02->nama_admin;
                        $nrp = $data02->username;
                    }
                } else {
                    $nama = $id_user;
                    $nrp = '';
                }
                if ($data02->tgl_kontrak > 0) {
                    $tgl_awal_kontrak = $data02->tgl_kontrak;
                } else {
                    $tgl_awal_kontrak = '';
                }
                if ($data02->habis_kontrak > 0) {
                    $tgl_akhir_kontrak = $data02->habis_kontrak;
                } else {
                    $tgl_akhir_kontrak = '';
                }
                if ($data01->tgl_ren_mob > 0) {
                    $tgl_ren_mob = $data01->tgl_ren_mob;
                } else {
                    $tgl_ren_mob = '';
                }
                if ($data01->tgl_real_mob > 0) {
                    $tgl_real_mob = $data01->tgl_real_mob;
                } else {
                    $tgl_real_mob = '';
                }
                if ($data01->tgl_ren_demob > 0) {
                    $tgl_ren_demob = $data01->tgl_ren_demob;
                } else {
                    $tgl_ren_demob = '';
                }
                if ($data01->tgl_real_demob > 0) {
                    $tgl_real_demob = $data01->tgl_real_demob;
                } else {
                    $tgl_real_demob = '';
                }
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, $no01);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $baris, $nrp);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $baris, $nama);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $baris, $data01->sakit);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $baris, $data01->ijin);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $baris, $data01->alpha);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $baris, $data01->cuti);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $baris, $data01->ket_absensi);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $baris, $data02->jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $baris, $data01->ket_jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $baris, $tgl_awal_kontrak);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $baris, $tgl_akhir_kontrak);
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $baris, $tgl_ren_mob);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $baris, $tgl_real_mob);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $baris, $tgl_ren_demob);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $baris, $tgl_real_demob);
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $baris, $data02->status);
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $baris, $data01->ket_mobdemob);
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $baris, $data01->ket_akhir);

                //STYLE ISI
                $excel->getActiveSheet()->getStyle('B' . $baris . ':T' . $baris)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J' . $baris . ':J' . $baris)->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('L' . $baris . ':M' . $baris)->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('R' . $baris . ':R' . $baris)->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('B' . $baris . ':T' . $baris)->getAlignment()->setWrapText(true);

                $no01++;
                $baris++;
            }
        } else {
            //JIKA BELUM ISI ABSEN
            $QN03 = $this->db->query("SELECT * FROM master_admin where pkp_akhir='$kode' order by kode");
            $baris = 7;
            if ($QN03->getNumRows() > 0) {
                $no01 = 1;
                foreach ($QN03->getResult() as $data03) {
                    if ($data03->tgl_kontrak > 0) {
                        $tgl_awal_kontrak = $data03->tgl_kontrak;
                    } else {
                        $tgl_awal_kontrak = '';
                    }
                    if ($data03->habis_kontrak > 0) {
                        $tgl_akhir_kontrak = $data03->habis_kontrak;
                    } else {
                        $tgl_akhir_kontrak = '';
                    }
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $baris, $no01);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $baris, $data03->username);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $baris, $data03->nama_admin);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $baris, $data03->jabatan);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $baris, $tgl_awal_kontrak);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $baris, $tgl_akhir_kontrak);
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('R' . $baris, $data03->status);
                    $excel->setActiveSheetIndex(0)->setCellValue('S' . $baris, '');
                    $excel->setActiveSheetIndex(0)->setCellValue('T' . $baris, '');
                    $excel->getActiveSheet()->getStyle('B' . $baris . ':T' . $baris)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('J' . $baris . ':J' . $baris)->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('L' . $baris . ':M' . $baris)->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('R' . $baris . ':R' . $baris)->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('B' . $baris . ':T' . $baris)->getAlignment()->setWrapText(true);
                    $no01++;
                    $baris++;
                }
            }
        }

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Mob Demob");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataAbsensi.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
    }

    public function dtutambah()
    {
        $now = date("Y-m-d");
        $id_pkp = $this->request->getPost('id'); // Assuming you get this from POST or GET request

        // Retrieve no_pkp and id_instansi from the database
        $QN2 = $this->db->query("SELECT * FROM master_pkp where id_pkp='$id_pkp'");
        foreach ($QN2->getResult() as $row2) {
            $no_pkp = $row2->no_pkp;
            $id_instansi = $row2->id_instansi;
        }

        // Retrieve no_instansi from the database
        $QN3 = $this->db->query("SELECT * FROM master_instansi where id='$id_instansi'");
        foreach ($QN3->getResult() as $row3) {
            $no_instansi = $row3->nomor;
        }

        // Define the location for storing the uploaded PDF
        $lokasi = './assets/pdf/dtu/' . $no_instansi . '/' . $no_pkp;

        // Check if directory exists, if not create it
        if (!file_exists($lokasi)) {
            mkdir($lokasi, 0777, true);
        }

        $teknis = 'dtu';
        $fileName = $teknis . $no_pkp . '.pdf'; // Define the file name

        $file = $this->request->getFile('berkas'); // Get the uploaded file

        // Check file size and type
        if ($file->getSize() > 100000000 || $file->getExtension() != 'pdf') {
            $this->session->setFlashdata('error', 'Ukuran file harus kurang dari 100MB');
        }

        // Move the file to the defined location with the defined file name
        if ($file->isValid() && !$file->hasMoved()) {
            $file->move($lokasi, $fileName);
            $datagbr1 = [
                "file_dtu" => $lokasi . '/' . $fileName,
            ];
            $this->db->table('master_pkp')->where('id_pkp', $id_pkp)->update($datagbr1);
        }
        $dataend = array(
            "tgl_ubah_dtu" => $now,
        );
        $this->db->table('master_pkp')->where('id_pkp', $id_pkp)->update($dataend);
        $this->session->setFlashdata('success', 'upload pdf');
        $redirectUrl = previous_url() ?? base_url();
        return redirect()->to($redirectUrl);
    }

    public function fototambah()
    {
        //THBL TGL BERJALAN//
        date_default_timezone_set("Asia/Jakarta");
        $now = date("Y-m-d");
        $now2 = date("Ymd");

        //ambil no urut terakhir//
        //INSTHBL-12345//
        $QN = $this->db->query("SELECT max(kode) as masKode FROM gambar order by kode");
        foreach ($QN->getResult() as $row) {
            $order = $row->masKode;
        }
        $noUrut = (int) substr($order, 8, 5);
        $noUrut++;
        //BL masKode//
        $bulanL = substr($order, 5, 2);
        $bln = substr($now, 5, 2);
        $tahun = substr($now, 2, 2);
        if ($bln == $bulanL) {
            $kode = 'GBR' . $tahun . $bln . '-' . sprintf("%05s", $noUrut);
        } else {
            $kode = 'GBR' . $tahun . $bln . '-' . '00001';
        }

        $post = $this->request->getPost();
        $id1 = 'GBR' . md5($kode);
        $id2 = 'GBR' . hash("sha1", $id1) . 'QNS';

        $array = [
            'id' => $id2,
            'id_pkp' => $post["id"],
            'kode' => $kode,
            'tgl_ubah' => $now,
            'id_ubah' => $post["id_ubah"],
        ];
        $this->db->table('gambar')->insert($array);
        $id_pkp = $post["id"];
        $QN2 = $this->db->query("SELECT * FROM master_pkp where id_pkp='$id_pkp'");
        foreach ($QN2->getResult() as $row2) {
            $no_pkp = $row2->no_pkp;
            $id_instansi = $row2->id_instansi;
        }
        $QN3 = $this->db->query("SELECT * FROM master_instansi where id='$id_instansi'");
        foreach ($QN3->getResult() as $row3) {
            $no_instansi = $row3->nomor;
        }
        $u = 0;
        $lokasi = './assets/images/dtu/' . $no_instansi . '/' . $no_pkp;

        if ($this->request->getFileMultiple('berkas')) {
            $files = $this->request->getFileMultiple('berkas');

            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getName();
                    $file->move($lokasi, $newName);

                    // Update database for each image
                    $updateData = [
                        'gambar' . ($u + 1) => $lokasi . '/' . $newName
                    ];

                    $this->db->table('gambar')->where('id', $id2)->update($updateData);

                    $u++;
                }
            }
        }

        if ($u < 3 || $u > 5) {
            return redirect()->back()->with('error', 'Choose between 3 and 5 images.');
        }
        $dataend = [
            "tgl_ubah_gbr" => $now,
        ];

        $this->db->table('master_pkp')->where('id_pkp', $id_pkp)->update($dataend);

        return redirect()->back()->with('success', $u . ' File/s uploaded successfully.');

    }



    public function teknistambah()
    {
        $now = date("Y-m-d");
        $post = $this->request->getPost();
        $id_pkp = $post['id']; // Assuming you get this from POST or GET request
        $QN0 = $this->db->query("SELECT * FROM pdf where id_pkp='$id_pkp'");
        if ($QN0->getNumRows() > 0) {
            $data0 = array(
                'tgl_ubah' => $now,
                'id_ubah' => $post["id_ubah"],
            );
            $this->db->table('pdf')->where('id_pkp', $id_pkp)->update($data0);
        } else {

            $QN = $this->db->query("SELECT max(kode) as masKode FROM pdf order by kode");
            foreach ($QN->getResult() as $row) {
                $order = $row->masKode;
            }
            $noUrut = (int) substr($order, 8, 5);
            $noUrut++;
            //BL masKode//
            $bulanL = substr($order, 5, 2);
            $bln = substr($now, 5, 2);
            $tahun = substr($now, 2, 2);
            if ($bln == $bulanL) {
                $kode = 'PDF' . $tahun . $bln . '-' . sprintf("%05s", $noUrut);
            } else {
                $kode = 'PDF' . $tahun . $bln . '-' . '00001';
            }

            $id1 = 'PDF' . md5($kode);
            $id2 = 'PDF' . hash("sha1", $id1) . 'QNS';

            $array = [
                'id' => $id2,
                'id_pkp' => $post["id"],
                'kode' => $kode,
                'tgl_ubah' => $now,
                'id_ubah' => $post["id_ubah"],
            ];

            $this->db->table('pdf')->insert($array);
        }
        // Retrieve no_pkp and id_instansi from the database
        $QN2 = $this->db->query("SELECT * FROM master_pkp where id_pkp='$id_pkp'");
        foreach ($QN2->getResult() as $row2) {
            $no_pkp = $row2->no_pkp;
            $id_instansi = $row2->id_instansi;
        }

        // Retrieve no_instansi from the database
        $QN3 = $this->db->query("SELECT * FROM master_instansi where id='$id_instansi'");
        foreach ($QN3->getResult() as $row3) {
            $no_instansi = $row3->nomor;
        }

        // Define the location for storing the uploaded PDF
        $lokasi = './assets/pdf/teknis/' . $no_instansi . '/' . $no_pkp;

        // Check if directory exists, if not create it
        if (!file_exists($lokasi)) {
            mkdir($lokasi, 0777, true);
        }

        $teknis = 'teknis';
        $fileName = $teknis . $no_pkp . '.pdf'; // Define the file name

        if ($this->request->getFileMultiple('berkas')) {
            $files = $this->request->getFileMultiple('berkas');
            $jumlah_berkas = count($this->request->getFileMultiple('berkas'));

            // Move the file to the defined location with the defined file name
            foreach ($files as $file) {

                if ($this->request->getFileMultiple('berkas')) {
                    $files = $this->request->getFileMultiple('berkas');
                    $jumlah_berkas = count($files);

                    for ($i = 0; $i < $jumlah_berkas; $i++) {
                        $fileName = $teknis . $i . '.pdf';
                        $file = $files[$i];

                        if ($file->isValid() && !$file->hasMoved()) {
                            $file->move($lokasi, $fileName);
                            $namagam = $file->getName();

                            // Dynamically update the database based on the current $i
                            if ($i == 0) {
                                $this->db->table('pdf')->where('id_pkp', $id_pkp)->update(["pdf1" => $lokasi . '/teknis0.pdf']);
                            } elseif ($i == 1) {
                                $this->db->table('pdf')->where('id_pkp', $id_pkp)->update(["pdf2" => $lokasi . '/teknis1.pdf']);
                            } elseif ($i == 2) {
                                $this->db->table('pdf')->where('id_pkp', $id_pkp)->update(["pdf3" => $lokasi . '/teknis2.pdf']);
                            } elseif ($i >= 3 && $i < 10) {
                                $this->db->table('pdf')->where('id_pkp', $id_pkp)->update(["pdf" . ($i + 1) => $lokasi . '/' . $namagam]);
                            }

                        }
                    }
                }
            }
        }

        $dataend = [
            "tgl_ubah_dtt" => $now,
        ];
        $this->db->table('master_pkp')->where('id_pkp', $id_pkp)->update($dataend);
        $this->session->setFlashdata('success', 'upload pdf teknis');
        $redirectUrl = previous_url() ?? base_url();
        return redirect()->to($redirectUrl);
    }


    public function import_mon_kry($id_pkp)
    {
        $data['kode'] = '02';
        $idQNS = session('idadmin');
        $isi = $this->db->table("master_admin")->where('id', $idQNS, 1)->get()->getRow();
        $kategoriQNS = $isi->kategori_user;
        if (!level_user('proyek', 'data', $kategoriQNS, 'read') > 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['kategori'] = $this->db->table('kategori_user')->get()->getResult();
        $data['golongan'] = $this->db->table('master_golongan')->orderBy('kode2')->get()->getResult();
        $data['proyek'] = $this->db->table('master_pkp a')->select("a.no_pkp, a.id_pkp, a.alias , b.nomor")->join('master_instansi b', 'a.id_instansi = b.id')->orderBy('no_pkp')->get()->getResult();

        $data['judul'] = '<a href="' . base_url() . 'proyek/edit_6/' . $id_pkp . '" style="color:white">MON.Karyawan | </a> <a style="color:white">Import</a>';

        $data['total_migrasi'] = $this->db->table("file_migrasi")->select("*")->where('tipe', 'DT_KR')->where('id_pkp', $id_pkp);
        $data['total1'] = $data['total_migrasi']->countAllResults();

        $errABS = 0;
        $errKETabs = 0;
        $errPOS = 0;
        $errMOB1 = 0;
        $errMOB2 = 0;
        $errDEMOB1 = 0;
        $errDEMOB2 = 0;
        $errUJG = 0;
        $errDOBEL = 0;

        $QN = $this->db->table("file_migrasi")->select("*")->where('tipe', 'DT_KR')->where('id_pkp', $id_pkp)->orderBy('kode')->get();
        // $QN = $this->db->table("file_migrasi")->select("*")->where('tipe', 'DT_KR')->where('id_pkp', $id_pkp)->groupBy("ket_1")->orderBy('kode')->get();
        //$QN = $this->db->query("SELECT * FROM file_migrasi where tipe='DT_KR' and id_pkp='$id_pkp' order by kode");
        foreach ($QN->getResult() as $row) {
            if ($row->ket_3 == '') {
                $errABS++;
            }
            if ($row->ket_4 == '') {
                $errABS++;
            }
            if ($row->ket_5 == '') {
                $errABS++;
            }
            if ($row->ket_6 == '') {
                $errABS++;
            }
            if ($row->ket_3 != '' and is_numeric($row->ket_3) != TRUE) {
                $errABS++;
            }
            if ($row->ket_4 != '' and is_numeric($row->ket_4) != TRUE) {
                $errABS++;
            }
            if ($row->ket_5 != '' and is_numeric($row->ket_5) != TRUE) {
                $errABS++;
            }
            if ($row->ket_6 != '' and is_numeric($row->ket_6) != TRUE) {
                $errABS++;
            }

            if (($row->ket_3 != '0' and is_numeric($row->ket_3) == TRUE) and $row->ket_7 == '') {
                $errKETabs++;
            }
            if (($row->ket_4 != '0' and is_numeric($row->ket_4) == TRUE) and $row->ket_7 == '') {
                $errKETabs++;
            }
            if (($row->ket_5 != '0' and is_numeric($row->ket_5) == TRUE) and $row->ket_7 == '') {
                $errKETabs++;
            }
            if (($row->ket_6 != '0' and is_numeric($row->ket_6) == TRUE) and $row->ket_7 == '') {
                $errKETabs++;
            }
            $n1_k7 = substr($row->ket_7, 0, 1);
            if ($n1_k7 == ' ') {
                $errKETabs++;
            }
            if ($row->ket_7 != '' and $n1_k7 != ' ' and $row->ket_3 == '0' and $row->ket_4 == '0' and $row->ket_5 == '0' and $row->ket_6 == '0') {
                $errKETabs++;
            }
            $n1_k8 = substr($row->ket_8, 0, 1);
            if ($n1_k8 == ' ') {
                $errPOS++;
            }
            if ($row->ket_8 == '') {
                $errPOS++;
            }
            if ($row->tgl_1 == 0) {
                $errMOB1++;
            }
            if ($row->tgl_2 == 0) {
                $errMOB2++;
            }
            if ($row->tgl_3 == 0) {
                $errDEMOB1++;
            }
            if ($row->tgl_4 == 0 and ($row->ket_10 == 'MUTASI' or $row->ket_10 == 'RESIGN')) {
                $errDEMOB2++;
            }
            if ($row->tgl_4 > 0 and ($row->ket_10 != 'MUTASI' and $row->ket_10 != 'RESIGN')) {
                $errUJG++;
            }
            if ($row->tgl_4 > 0 and ($row->ket_10 == 'TASK FORCE')) {
                $errUJG++;
            }
            if ($row->ket_1 != '') {
                $errDOBEL++;
            }
        }

        $data['total2'] = $errABS + $errKETabs + $errPOS + $errMOB1 + $errMOB2 + $errDEMOB1 + $errDEMOB2 + $errUJG + ($data['total1'] - $errDOBEL);
        $data['total3'] = $data['total1'] - $errDOBEL;
        $data['total2a'] = $errABS;
        $data['total2b'] = $errKETabs;
        $data['total2c'] = $errPOS;
        $data['total2d'] = $errMOB1;
        $data['total2e'] = $errMOB2;
        $data['total2f'] = $errDEMOB1;
        $data['total2g'] = $errDEMOB2;
        $data['total2h'] = $errUJG;
        $data['id_pkp'] = $id_pkp;
        $data['kategoriQNS'] = $kategoriQNS;
        $data['kategori'] = $kategoriQNS;
        return view('proyek/import_mon_kry', $data);
    }



}