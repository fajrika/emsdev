<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MigrasiTable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        // if (!$this->m_login->status_login())
        //     redirect(site_url());
        $this->load->model('Sync/m_purpose_unit');
        $this->load->model('m_core');
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
    }

    public function t_tagihan()
    {

        ini_set('memory_limit', '-1'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize', '2048000'); // Setting to 512M
        // ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '2048000');
        $dbBaru = 'emsdev2baru';
        $dbLama = 'emsdev2';
        $data = $this->db
            ->select("*,concat(unit_id,' ',periode) as uid")
            ->from("$dbLama.dbo.t_tagihan")->get()->result();
        $data2 = [];
        foreach ($data as $k => $v) {
            // if(in_array())
        }
        $a = $data[0];
        unset($data);
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($a));
    }
    public function add()
    {
    }
    public function save()
    {
    }
    public function erems()
    {
    }
    public function get_ajax_purpose_unit_by_source()
    {
    }
}
