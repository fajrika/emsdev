<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->model('m_login');
		if (!$this->m_login->status_login()) redirect(site_url());
		$this->load->model('transaksi/m_pembayaran');
		$this->load->model('transaksi/m_deposit');
		
        $this->load->model('m_core');
        ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
    }

    public function index($unit_id)
    {
        
        $this->load->model("core/m_tagihan");
        $project = $this->m_core->project();
        $param = (object)[
            'unit_id' => [$unit_id]
        ];
        $tagihans = $this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"));
        echo("tagihans<pre>");
            print_r($tagihans);
        echo("</pre>");
        $vas = $this->m_tagihan->get_va($unit_id);
        echo("vas<pre>");
            print_r($vas);
        echo("</pre>");
        
    }
}
