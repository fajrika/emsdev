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
            'unit_id' => [$unit_id],
            // 'periode_awal' => '2019-07-01',
            // 'periode_akhir' => '2019-12-01'
        ];
        // $tagihans = $this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"),'unit');
        // echo("PeriodeTagihans<pre>");
        //     print_r($tagihans);
        // echo("</pre>");
        // echo("groupperiode<pre>");
        //     print_r($this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"),'periode'));
        // echo("</pre>");
        $tagihans = $this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"),'unit');
        // echo("groupunit<pre>");
        //     print_r($this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"),'unit'));
        // echo("</pre>");
        echo("<pre>");
            print_r($this->m_tagihan->get_lingkungan($param, date("Y-m-d")));
        echo("</pre>");
        die;
        $finalTagihans = [];
        foreach ($tagihans as $iterasi => $tagihan) {
            $tmp = (object)[
                "unit_id" => 0,
                "tagihan_lingkungan_tanpa_ppn" => 0,
                "tagihan_lingkungan" => 0,
                "denda_lingkungan" => 0,
                "tagihan_air_tanpa_ppn" => 0,
                "denda_air" => 0,
                "periode" => null
            ];
            if(isset($tagihan->lingkungan->id)){
                $tmp->unit_id = $tagihan->lingkungan->unit_id;
                $tmp->tagihan_lingkungan_tanpa_ppn = $tagihan->lingkungan->nilai_tagihan_tanpa_ppn;
                $tmp->tagihan_lingkungan = $tagihan->lingkungan->nilai_tagihan;
                $tmp->denda_lingkungan = $tagihan->lingkungan->nilai_denda;
                $tmp->periode = $tagihan->lingkungan->periode;
            }elseif(isset($tagihan->air->id)){
                $tmp->unit_id = $tagihan->air->unit_id;
                $tmp->tagihan_air_tanpa_ppn = $tagihan->air->nilai_tagihan;
                $tmp->denda_air = $tagihan->air->nilai_denda;
                $tmp->periode = $tagihan->air->periode;
            }
            array_push($finalTagihans,$tmp);
        }
        $vas = $this->m_tagihan->get_va($unit_id);
        echo("vas<pre>");
            print_r($vas);
        echo("</pre>");
        echo("vas<pre>");
            print_r($finalTagihans);
        echo("</pre>");
        
    }
}
