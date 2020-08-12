<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desktop_Tagihan_Lingkungan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        if (!$this->m_login->status_login())
            redirect(site_url());
        $this->load->model('Sync/m_desktop_transaksi_lingkungan');
        $this->load->model('m_core');
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
    }
    public function add()
    {
        ini_set('memory_limit', '-1');
        ini_set('sqlsrv.ClientBufferMaxKBSize', '5242880'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '5242880'); // Setting to 512M - for pdo_sqlsrv
        ini_set('max_execution_time', '-1');

        $this->load->view('core/header');
        $this->load->model('alert');
        $this->alert->css();

        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Sync > Desktop Tagihan Lingkungan', 'subTitle' => 'Add']);
        $this->load->view('sync/desktop_tagihan_lingkungan', [
            'project' => $this->db->from("project")->get()->result(),
            'schemas' => $this->db->select("name")->from("ems_temp.sys.schemas")->get()->result()
        ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }
    public function save()
    {
        ini_set('memory_limit', '-1');
        ini_set('sqlsrv.ClientBufferMaxKBSize', '5242880'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '5242880'); // Setting to 512M - for pdo_sqlsrv
        ini_set('max_execution_time', '-1'); // Setting to 512M - for pdo_sqlsrv

        $this->m_desktop_transaksi_lingkungan->save_lingkungan(
            $this->input->get("project_id"),
            $this->input->get("source"),
            $this->input->get("denda_jenis_service"),
            $this->input->get("denda_nilai_service"),
            $this->input->get("jarak_periode")
        );
        $this->m_desktop_transaksi_lingkungan->save_air(
            $this->input->get("project_id"),
            $this->input->get("source"),
            $this->input->get("denda_jenis_service"),
            $this->input->get("denda_nilai_service"),
            $this->input->get("jarak_periode")
        );
    }
}
