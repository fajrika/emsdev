<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P_pemutihan extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('m_login');
		if(!$this->m_login->status_login()) redirect(site_url());
		$this->load->model('report/m_pemutihan');
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
		$this->load->view('core/header');
		$this->load->view('core/side_bar',['menu' => $GLOBALS['menu']]);
		$this->load->view('core/top_bar',['jabatan' => $GLOBALS['jabatan'],'project' => $GLOBALS['project']]);
		$this->load->view('core/body_header',['title' => 'Report > Pemutihan ','subTitle' => 'List']);
		$this->load->view('proyek/report/pemutihan/view',['data'=>$this->m_pemutihan->getListPemutihan($GLOBALS['project']->id)]);
		$this->load->view('core/body_footer');
		$this->load->view('core/footer');
	}
    public function ajax_get_detail($pemutihan_id)
	{
		echo json_encode($this->m_pemutihan->getListDetailPemutihan($pemutihan_id));
	}
	
}