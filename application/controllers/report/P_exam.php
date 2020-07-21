<?php
defined('BASEPATH') or exit('No direct script access allowed');

class P_exam extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('m_login');
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
		$this->CI = &get_instance();

		// echo ("<pre>");
		// print_r($this->CI->load->view("proyek/report/exam/index", [], TRUE));
		// echo ("</pre>");
		// die;
		$this->load->view("layouts/admin_gentelella", [
			"title_submenu" => "Report > Exam",
			"css" 			=> 	$this->load->view("layouts/css/dataTables", [], TRUE).
								$this->load->view("exam/indexcss",[],TRUE),
			"content" 		=> 	$this->load->view("proyek/report/exam/index", [], TRUE),
			"js" 			=> 	$this->load->view("layouts/js/dataTables", [], TRUE).
								$this->load->view("exam/indexjs",[],TRUE),
		]);
		// $this->load->view('core/header');
		// $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
		// $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
		// $this->load->view('core/body_header', ['title' => 'Transaksi Service > Report Pembayaran Service ', 'subTitle' => 'Report Harian, Bulanan']);
		// $this->load->view('proyek/report/exam/index');
		// $this->load->view('core/body_footer');
		// $this->load->view('core/footer');
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
