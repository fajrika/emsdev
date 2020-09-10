<?php
defined('BASEPATH') or exit('No direct script access allowed');

class p_unit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('core/m_unit');
		$this->load->model('m_core');
		global $jabatan;
		$jabatan = $this->m_core->jabatan();
		global $project;
		$project = $this->m_core->project();
		global $menu;
		$menu = $this->m_core->menu();
		// echo("<pre>");
		//     print_r($menu);
		// echo("</pre>");
		global $unit_id;
		$unit_id = $this->m_core->unit_id();
		//var_dump($this->session->userdata('name'));
	}
	public function index()
	{
		$this->load->view('core/header');
		$this->load->model('alert');
		$this->alert->css();
		$this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
		$this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
		$this->load->view('unit/dashboard');
		$this->load->view('core/body_footer');
		$this->load->view('core/footer');
	}
	public function api_unit($unit_id = 0)
	{
		if ($unit_id === 0) {
			$unit =
				$this->db
				->select("unit.id as id,CONCAT(kawasan.name,'-',blok.name,'/',unit.no_unit,'-',customer.name) as text")
				->from('unit')
				->join('blok', 'blok.id = unit.blok_id')
				->join('kawasan', 'kawasan.id = blok.kawasan_id')
				->join('customer', 'customer.id = unit.pemilik_customer_id')
				->where('unit.project_id', $GLOBALS['project']->id)
				->where("CONCAT(kawasan.name,'-',blok.name,'/',unit.no_unit,'-',customer.name) like '%" . $this->input->get('data') . "%'")
				->limit(10)
				->get()->result();
			$data = (object)[];
			$data->result = $unit;
			$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode($data->result));
		} elseif ($unit_id > 0) {
			$result = (object)[];

			$info_unit_customer = $this->db
				->select(
					"CONCAT(project.source_id,kawasan.code,blok.code,'/',unit.no_unit) as uid,
				unit.luas_bangunan,
				isnull(unit.luas_taman,0) as luas_taman,
				unit.luas_tanah,
				concat(jenis_golongan.code,' - ',jenis_golongan.description) as golongan,
				'Rumah' as purpose_use,
				'-' as type_unit,
				convert(varchar,tgl_st,103) as tgl_st,

				pemilik.id as pemilik_id,
				pemilik.name as pemilik_name,
				pemilik.mobilephone1 as pemilik_mobilephone1, 
				pemilik.mobilephone2 as pemilik_mobilephone2, 
				pemilik.address as pemilik_address, 
				
				penghuni.id as penghuni_id,
				penghuni.name as penghuni_name,
				penghuni.mobilephone1 as penghuni_mobilephone1, 
				penghuni.mobilephone2 as penghuni_mobilephone2, 
				penghuni.address as penghuni_address"
				)
				->from("unit")
				->join("project", "project.id = " . $GLOBALS['project']->id)
				->join("blok", "blok.id = unit.blok_id")
				->join("kawasan", "kawasan.id = blok.kawasan_id")
				->join('jenis_golongan', 'jenis_golongan.id = unit.gol_id', 'LEFT')
				->join('customer as pemilik', "pemilik.id = unit.pemilik_customer_id", "LEFT")
				->join('customer as penghuni', "penghuni.id = unit.penghuni_customer_id", "LEFT")
				->where("unit.id", $unit_id)
				->get()->row_array();
			if ($info_unit_customer) {
				$result->info_unit = array_slice($info_unit_customer, 0, 8);
				$result->info_pemilik = array_slice($info_unit_customer, 8, 5);
				$result->info_penghuni = array_slice($info_unit_customer, 13, 5);

				$result->info_tagihan_retribusi = $this->db
					->select("
					t_tagihan.air as tagihan_air,
					t_tagihan.lingkungan as tagihan_lingkungan
				")
					->select("t_tagihan.air as total", false)
					->from('t_tagihan')
					->get()->row();
				return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(
						json_encode($result)
					);
			}
			return $this->output
				->set_content_type('application/json')
				->set_status_header(204); //no content
		}
	}
}
