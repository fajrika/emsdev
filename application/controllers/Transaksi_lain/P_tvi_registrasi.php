<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_tvi_registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->model('transaksi_lain/m_registrasi_liaison_officer');

        $this->load->model('transaksi_lain/m_tvi_registrasi');
        $this->load->model('m_core');
        $this->load->model('m_login');
        if (!$this->m_login->status_login()) {
            redirect(site_url());
        }
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
        ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
    }

    public function index()
    {
        $registrasis = $this->m_tvi_registrasi->get();
        $this->load->model('alert');
        $this->load->view('core/header');
        $this->alert->css();
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/tvi_registrasi/view', [
            'registrasis' => $registrasis
        ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($this->session->flashdata('success')) {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => $this->session->flashdata('success'), 'type' => 'success']);
        } elseif ($this->session->flashdata('danger')) {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => $this->session->flashdata('danger'), 'type' => 'danger']);
        }
    }

    public function add()
    {
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'Add']);
        $this->load->view('proyek/transaksi_lain/tvi_registrasi/add', 
            [ 
            ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }
    public function get_ajax_unit()
	{
		echo json_encode($this->m_registrasi_liaison_officer->get_unit($this->input->get('data')));
    }
    public function get_ajax_unit_detail(){
        $project = $this->m_core->project();
        $this->load->model("core/m_tagihan");
        $unit_id = $this->input->get("id");
        $unit_detail = $this->m_registrasi_liaison_officer->get_unit_detail($unit_id);
        $tagihan_air = $this->m_tagihan->air(
                                        $project->id,
                                        [
                                            'status_tagihan'=>[0,2,3,4],
                                            'unit_id'=>[$unit_id],
                                            'periode'=>date("Y-m-d")
                                        ]);
		$tagihan_lingkungan = $this->m_tagihan->lingkungan(
                                        $project->id,
                                        [
                                            'status_tagihan'=>[0,2,3,4],
                                            'unit_id'=>[$unit_id],
                                            'periode'=>date("Y-m-d")
                                        ]);
        $total = 0;
        foreach ($tagihan_air as $k => $v) {
            $total += $v->nilai_tagihan + $v->nilai_denda + $v->belum_bayar + 0 - ($v->view_pemutihan_nilai_tagihan + $v->view_pemutihan_nilai_denda);
        }   
        foreach ($tagihan_lingkungan as $k => $v) {
            $total += $v->nilai_tagihan + $v->nilai_denda + $v->belum_bayar + 0 - ($v->view_pemutihan_nilai_tagihan + $v->view_pemutihan_nilai_denda);
        }   
        $unit_detail->outstading = $total;
        echo json_encode($unit_detail);

    }
    public function get_ajax_paket()
    {
        echo json_encode($this->m_tvi_registrasi->get_paket($this->input->get('data')));
    }
    public function get_ajax_paket_detail(){
        echo json_encode($this->m_tvi_registrasi->get_paket_detail($this->input->get('id')));

    }
    public function save(){
        // echo("<pre>");
        //     print_r($this->input->get());
        // echo("</pre>");
        // $user_id = $this->m_core->user_id();
        // echo("<pre>");
        //     print_r($user_id);
        // echo("</pre>");
        // die;
        $status = $this->m_tvi_registrasi->save($this->input->post());
        if ($status)       
            $this->session->set_flashdata('success','Data berhasil di simpan');
        else                        
            $this->session->set_flashdata('danger','Data sudah ada');
        redirect('transaksi_lain/P_tvi_registrasi');
        
    }


}
