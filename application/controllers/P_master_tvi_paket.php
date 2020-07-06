<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_master_tvi_paket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        if (!$this->m_login->status_login()) {
            redirect(site_url());
        }
        $this->load->model('m_tvi_paket');
        $this->load->model('m_tvi_isp');
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
        $datas = $this->m_tvi_paket->get();
        $this->load->model('alert');
        $this->load->view('core/header');
        $this->alert->css();
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Service TVI > TVI', 'subTitle' => 'List']);
        $this->load->view('proyek/master/tvi_paket/view', ['datas' => $datas]);
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
        $datas = $this->m_tvi_isp->get();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Master > Service TVI > TVI', 'subTitle' => 'Add']);
        $this->load->view('proyek/master/tvi_paket/add',['datas'=> $datas]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function save()
    {
        $status = $this->m_tvi_paket->save($this->input->post());
        if ($status)       
            $this->session->set_flashdata('success','Data berhasil di simpan');
        else                        
            $this->session->set_flashdata('danger','Data sudah ada');
        redirect('P_master_tvi_paket');
    }

    public function edit()
    {
        $project = $this->m_core->project();

        $paket = $this->db->from('m_tvi_paket')
                                ->where('id',$this->input->get('id'))
                                ->get()->row();
        $isps = $this->db->from('m_tvi_isp')
                                ->where('project_id',$project->id)
                                ->get()->result();
        $this->load->model('alert');
        $this->load->view('core/header');
        $this->alert->css();
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Service TVI > TVI', 'subTitle' => 'Edit']);
        $this->load->view('proyek/master/tvi_paket/edit', 
            [
                'paket' => $paket,
                'isps' => $isps
            ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($this->session->flashdata('success')) {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => $this->session->flashdata('success'), 'type' => 'success']);
        } elseif ($this->session->flashdata('danger')) {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => $this->session->flashdata('danger'), 'type' => 'danger']);
        }
    }
    public function update()
    {
        $status = $this->m_tvi_paket->update($this->input->get('id'),$this->input->post());
        if ($status)       
            $this->session->set_flashdata('success','Data berhasil di simpan');
        else                        
            $this->session->set_flashdata('danger','Data sudah ada');
        redirect("P_master_tvi_paket/edit?id=".$this->input->get('id'));
    }

    public function delete()
    {
        $status = $this->m_tvi_paket->delete($this->input->get('id'));
        if ($status)       
            $this->session->set_flashdata('success','Data berhasil di Delete');
        else                        
            $this->session->set_flashdata('danger','Data sudah ada');
        redirect("P_master_tvi_paket");
    }
}
