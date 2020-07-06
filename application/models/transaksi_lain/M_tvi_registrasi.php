<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_tvi_registrasi extends CI_Model
{
    public function get()
    {
        $project = $this->m_core->project();
        $data = $this->db->select("
                                    t_tvi_registrasi.*,
                                    t_tvi_registrasi_detail.id,
                                    t_tvi_registrasi_detail.unit,
                                    t_tvi_registrasi_detail.customer_name,
                                    t_tvi_registrasi_detail.isp_name,
                                    t_tvi_registrasi_detail.paket_name,
                                    t_tvi_registrasi_detail.create_user_name                                    
                                ")
                        ->from("t_tvi_registrasi")
                        ->join("t_tvi_registrasi_detail",
                                "t_tvi_registrasi_detail.t_tvi_registrasi_id = t_tvi_registrasi.id")
                        ->where("t_tvi_registrasi.project_id",$project->id)
                        ->where("t_tvi_registrasi.active",1)
                        ->where("t_tvi_registrasi.delete",0)
                        ->get()->result();
        return $data;
    }
    public function get_paket($data)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        return $this->db
                            ->select("m_tvi_paket.id, concat(m_tvi_isp.name,' - ',m_tvi_paket.name) as text")
                            ->from("m_tvi_paket")
                            ->join("m_tvi_isp",
                                    "m_tvi_isp.id = m_tvi_paket.m_tvi_isp_id")
                            ->where("m_tvi_paket.project_id",$project->id)
                            ->where("m_tvi_paket.active",1)
                            ->where("m_tvi_isp.active",1)
                            ->where("m_tvi_paket.delete",0)
                            ->where("m_tvi_isp.delete",0)

                            ->where("concat(m_tvi_isp.name,' - ',m_tvi_paket.name) like '%" . $data . "%'")
                            ->get()->result();
    }
    public function get_paket_detail($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        return $this->db->select("
                                m_tvi_paket.*,
                                m_tvi_isp.name as isp_name
                            ")
                            ->from("m_tvi_paket")
                            ->join("m_tvi_isp",
                                    "m_tvi_isp.id = m_tvi_paket.m_tvi_isp_id")
                            ->where("m_tvi_paket.active",1)
                            ->where("m_tvi_paket.project_id",$project->id)
                            ->where("m_tvi_paket.id",$id)
                            ->where("m_tvi_paket.delete",0)
                            ->order_by("m_tvi_paket.id", "desc")
                            ->get()->row();
    }
    public function save($data){
        $data = (object)$data;
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();
        $user_name = $this->db->from("user")->where("id",$user_id)->get()->row()->name;
        $m_tvi_paket = $this->db->from("m_tvi_paket")
                            ->where("id",$data->paket_id)
                            ->get()->row();
        $m_tvi_isp = $this->db->from("m_tvi_isp")
                                ->where("id",$m_tvi_paket->m_tvi_isp_id)
                                ->get()->row();
        $unit = $this->db->select("unit.no_unit,
                                    blok.name as blok,
                                    kawasan.name as kawasan,
                                    customer.name as pemilik")
                            ->from("unit")
                            ->join("blok",
                                    "blok.id = unit.blok_id")
                            ->join("kawasan",
                                    "kawasan.id = blok.kawasan_id")
                            ->join("customer",
                                    "customer.id = unit.pemilik_customer_id")
                            ->where("unit.id", $data->unit_id)
                            ->get()->row();
        
        $this->db->insert("t_tvi_registrasi",[
            "no_registrasi"     => "",
            "project_id"        => $project->id,
            "unit_id"           => $data->unit_id?$data->unit_id:0,
            "unit_virtual_id"   => $data->unit_virtual_id?$data->unit_virtual_id:0,
            "m_tvi_paket_id"    => $data->paket_id,
            "m_tvi_isp_id"      => $m_tvi_paket->m_tvi_isp_id,
            "harga"             => str_replace(',','',$data->harga),
            "harga_pasang_baru" => str_replace(',','',$data->harga_pasang_baru),
            "diskon"            => str_replace(',','',$data->nilai_diskon),
            "description"       => $data->keterangan,
            "status_tagihan"    => 0,
            "status_registrasi" => 0,
            "tanggal_registrasi"            => date("Y-m-d"),
            "tanggal_rencana_pemasangan"    => null,
            "tanggal_pemasangan"            => null,
            "tanggal_rencana_aktifasi"      => $data->tgl_rencana_aktifasi?
                                                substr($data->tgl_rencana_aktifasi,6,4)
                                                ."-"
                                                .substr($data->tgl_rencana_aktifasi,3,2)
                                                ."-"
                                                .substr($data->tgl_rencana_aktifasi,0,2):null,
            "tanggal_aktifasi"  => null,
            "durasi_paket"      => $m_tvi_paket->durasi,
            "tipe_durasi_paket" => $m_tvi_paket->tipe_durasi,
            "active"            => 1,
            "delete"            => 0,
            "create_user_id"    => $user_id,
            "total_tagihan"     => str_replace(',','',$data->total) 
        ]);
        $this->db->insert("t_tvi_registrasi_detail",[
            "t_tvi_registrasi_id"   => $this->db->insert_id(),
            "unit"                  => "$unit->kawasan $unit->blok/$unit->no_unit",
            "customer_name"         => $unit->pemilik,
            "isp_name"              => $m_tvi_isp->name,
            "paket_name"            => $m_tvi_paket->name,
            "create_user_name"      => $user_name,
            "luas_bangunan"         => str_replace(',','',$data->luas_bangunan),
            "luas_tanah"            => str_replace(',','',$data->luas_tanah),
            "outstading"            => str_replace(',','',$data->outstanding),
            "mobilephone"           => $data->mobilephone,
            "email"                 => $data->email,
            "bandwidth"             => str_replace(',','',$data->bandwidth),
            "harga"                 => str_replace(',','',$data->harga),
            "harga_pasang_baru"     => str_replace(',','',$data->harga_pasang_baru),
            "harga_progresif"       => str_replace(',','',$data->harga_progresif),

        ]);
        $this->db->where('unit_id',$data->unit_id);            
        $this->db->where('periode',date("Y-m-01"));
        $this->db->where('proyek_id',$project->id);                
        $tagihan_sudah_ada = $this->db->get('t_tagihan');
        if (!$tagihan_sudah_ada->num_rows()) {
            $data_tagihan = (object)[];
            $data_tagihan->proyek_id                    = $project->id;
            $data_tagihan->unit_id                      = $data->unit_id;
            $data_tagihan->periode                      = date("Y-m-01");

            $this->db->insert('t_tagihan',$data_tagihan);
            $data_tagihan->t_tagihan_id = $this->db->insert_id();
        }else{
            $data_tagihan->t_tagihan_id = $tagihan_sudah_ada->row()->id;
        }
        $this->db->insert("t_tagihan_tvi",[
            "proyek_id" => $project->id,
            "unit_id"           => $data->unit_id?$data->unit_id:0,
            "unit_virtual_id"   => $data->unit_virtual_id?$data->unit_virtual_id:0,
            "kode_tagihan"      => "",
            "periode"           => date("Y-m-01"),
            "status_tagihan"    => 0,
            "t_tagihan_id"      => $data_tagihan->t_tagihan_id,
            "total_tagihan"     => str_replace(',','',$data->total),
            "diskon"            => str_replace(',','',$data->nilai_diskon),
            "harga_paket"       => str_replace(',','',$data->harga),
            "harga_pasang_baru" => str_replace(',','',$data->harga_pasang_baru),
            "harga_progresif"   => str_replace(',','',$data->harga_progresif),
        ]);
        return true;
    }
}
