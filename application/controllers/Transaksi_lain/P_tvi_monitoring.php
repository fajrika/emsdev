<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_tvi_monitoring extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->model('transaksi_lain/m_registrasi_liaison_officer');

        $this->load->model('transaksi_lain/m_tvi_monitoring');
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
        $monitorings = $this->m_tvi_monitoring->get();
        $this->load->model('alert');
        $this->load->view('core/header');
        $this->alert->css();
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Monitoring', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/tvi_monitoring/view', [
            'monitorings' => $monitorings
        ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($this->session->flashdata('success')) {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => $this->session->flashdata('success'), 'type' => 'success']);
        } elseif ($this->session->flashdata('danger')) {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => $this->session->flashdata('danger'), 'type' => 'danger']);
        }
    }

    public function ajax_get_detail(){
        // echo("<pre>");
        //     print_r($this->input->get());
        // echo("</pre>");
        // $user_id = $this->m_core->user_id();
        // echo("<pre>");
        //     print_r($user_id);
        // echo("</pre>");
        // die;
        echo(json_encode($this->m_tvi_monitoring->get_detail($this->input->post("id"))));
        // $status = $this->m_tvi_monitoring->action($this->input->get("id"),$this->input->get("status"));
        // if ($status)       
        //     $this->session->set_flashdata('success','Data berhasil di simpan');
        // else                        
        //     $this->session->set_flashdata('danger','Data sudah ada');
        // redirect('transaksi_lain/P_tvi_monitoring');
        
    }


}
