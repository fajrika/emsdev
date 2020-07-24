<?php
defined('BASEPATH') or exit('No direct script access allowed');

class P_kolektabilitas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('m_login');
        $this->load->model('core/m_tagihan');
        $this->load->model('transaksi/m_aging');
		if (!$this->m_login->status_login()) redirect(site_url());
		$this->load->model('m_core');
		global $jabatan;
		$jabatan = $this->m_core->jabatan();
		global $project;
		$project = $this->m_core->project();
		global $menu;
		$menu = $this->m_core->menu();
	}
	public function index()
	{
		$data['kawasan'] = $this->db->where("project_id", $GLOBALS['project']->id)->order_by('id ASC')->get('kawasan')->result();
		$this->load->view("layouts/admin_gentelella", [
			"title_submenu" => "Report > Kolektabilitas",
			"css" 			=> 	$this->load->view("layouts/css/dataTables", [], TRUE).
								$this->load->view("proyek/report/kolektibilitas/indexcss.php",[],TRUE),
			"content" 		=> 	$this->load->view("proyek/report/kolektibilitas/index", $data, TRUE),
			"js" 			=> 	$this->load->view("layouts/js/dataTables", [], TRUE).
								$this->load->view("proyek/report/kolektibilitas/indexjs",[],TRUE),
		]);
	}
	public function index2()
	{
		$this->load->view("layouts/admin_gentelella2", [
			"title_submenu" => "Report > P_Exam",
			"css" => "",
			"Content" => "",
			"js"  => "",
			"menu" => $GLOBALS['menu']
		]);
		// $this->load->view('core/header');
		// $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
		// $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
		// $this->load->view('core/body_header', ['title' => 'Transaksi Service > Report Pembayaran Service ', 'subTitle' => 'Report Harian, Bulanan']);
		// $this->load->view('proyek/report/exam/index');
		// $this->load->view('core/body_footer');
		// $this->load->view('core/footer');
	}

    public function generate()
    {
        // print_r($_POST);exit();
        $get_month      = $this->input->post('month');
        $month          = str_pad($get_month, 2, 0, STR_PAD_LEFT);
        $get_periode    = $this->input->post('periode_awal');
        $column_ke      = $this->input->post('column_ke');
        $id_kawasan     = $this->input->post('id_kawasan');

        $blok           = 1;
        $periode_awal   = $month.'/'.substr($get_periode, 6, 4); //"04/2020";
        $periode_akhir  = $month.'/'.substr($get_periode, 6, 4); //"04/2020";
        $metode_tagihan = [1, 2];
        $param          = (object)[];

        $periode_awal           = substr($periode_awal, 3, 4) . "-" . substr($periode_awal, 0, 2) . "-01";
        $periode_akhir          = substr($periode_akhir, 3, 4) . "-" . substr($periode_akhir, 0, 2) . "-01";
        $param->status_tagihan  = [1, 4];
        $param->kawasan_id      = $id_kawasan;
        $param->project_id      = $GLOBALS['project']->id;
        $param->periode_awal    = $periode_awal;
        $param->periode_akhir   = $periode_akhir;
        $param->date            = date("Y-m-d");

        $tagihans = $this->m_tagihan->get_tagihan_gabungan([
			"status_tagihan" => [1,4],
			"kawasan_id" => $id_kawasan,
			"project_id" => $GLOBALS['project']->id,
			"periode_awal" => $periode_awal,
			"periode_akhir" => $periode_akhir, 
			"date" => date("Y-m-d"),
			"service_jenis_id" => [1]
		],'unit');
		$tagihans2 = $this->m_tagihan->get_lingkungan([
			"status_tagihan" => [1,4],
			"kawasan_id" => $id_kawasan,
			"project_id" => $GLOBALS['project']->id,
			"periode_awal" => $periode_awal,
			"periode_akhir" => $periode_akhir, 
			"date" => date("Y-m-d")
		]);
		$sumGabungan = 0;
		foreach ($tagihans as $key => $subtagihans) {
			foreach ($subtagihans as $key => $tagihan) {
				$sumGabungan += $tagihan->final_nilai_tagihan_tanpa_ppn;
			}
		}
		$sumIPL = 0;

		foreach ($tagihans2 as $key => $value) {
            $sumIPL += $value->final_nilai_tagihan_tanpa_ppn;
        }
		
		$tagihan = [
			"param" => $param,
			"sumGabungan" => $sumGabungan,
			"sumIPL" => $sumIPL,
			"gabungan" => $tagihans,
			"ipl" => $tagihans2,
		];
		
		echo(json_encode($tagihan));
		die;
        print_r($tagihans);exit();
        // print_r($tagihans2);exit();

        $sum_nilai_tagihan_tanpa_ppn = 0;
        foreach ($tagihans as $key => $value) {
            if ($value->lingkungan) {
                $sum_nilai_tagihan_tanpa_ppn += $value->lingkungan->final_nilai_tagihan_tanpa_ppn;
            }
        }


        $sum_nilai_tagihan_tanpa_ppn2 = 0;
        foreach ($tagihans2 as $key => $value) {
            $sum_nilai_tagihan_tanpa_ppn2 += $value->final_nilai_tagihan_tanpa_ppn;
        }

        // print_r('gabungan: '.$sum_nilai_tagihan_tanpa_ppn . ' ' . 'lingkungan: ' . $sum_nilai_tagihan_tanpa_ppn2);exit();

        echo json_encode(array(
            'bulan_ke' => $get_month,
            'column_ke' => $column_ke,
            'nilai_tagihan' => $sum_nilai_tagihan_tanpa_ppn
        ));
    }

	public function ajax_get_kawasan(){
		$kawasans = 
			$this->db->select("kawasan.id, concat(kawasan.code, ' - ', kawasan.name) as text")
			->from('kawasan')
			->where('kawasan.project_id', $GLOBALS['project']->id)
			->where("CONCAT(kawasan.code,' - ',kawasan.name) like '%" . $this->input->get('data') . "%'")
			->limit(10)
			->get()->result();
		$data = (object)[];
		$data->result = [];
		$data->result[0] = (object)[];
		$data->result[0]->text = 'Project';
		$data->result[0]->children = $kawasans;
		$data->result[1] = (object)[];
		$data->result[1]->text = 'Non Project';
		$data->result[1]->children = [];
		echo json_encode($data->result);
	}
	public function ajax_get_view()
	{

		$project = $this->m_core->project();
		$table =    "unit
                    join blok
                        ON blok.id = unit.blok_id
                    JOIN kawasan
                        ON kawasan.id = blok.kawasan_id
                    JOIN customer as pemilik
                        ON pemilik.id = unit.pemilik_customer_id
                    LEFT JOIN purpose_use
                        ON purpose_use.id = unit.purpose_use_id
                    LEFT JOIN unit_lingkungan
                        ON unit_lingkungan.unit_id = unit.id
                    LEFT JOIN unit_air
		                ON unit_air.unit_id = unit.id
                    WHERE unit.project_id = $project->id";
		$primaryKey = 'unit.id';
		$columns = array(
			array('db' => 'kawasan.name as kawasan_name', 'dt' => 0),
			array('db' => 'blok.name as blok_name',  'dt' => 1),
			array('db' => 'unit.no_unit as no_unit',   'dt' => 2),
			array('db' => 'pemilik.name as pemilik_name',     'dt' => 3),
			array('db' => "FORMAT (tgl_st, 'dd-MM-yyyy') as tgl_st",     'dt' => 4),
			array('db' => "isnull(purpose_use.name,'-') as purpose_use_name",     'dt' => 5),
			array('db' => "CASE
                                WHEN unit_air.sub_gol_id is not null or unit_lingkungan.sub_gol_id is not null THEN 'Sudah di Setting'
                                ELSE 'Belum di Setting'
                            END as status_setting",     'dt' => 6),
			array('db' => 'unit.id as id',     'dt' => 7)
		);
	}
}
