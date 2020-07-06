<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tvi_monitoring extends CI_Model
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
                                    t_tvi_registrasi_detail.paket_name
                                ")
                        ->from("t_tvi_registrasi")
                        ->join("t_tvi_registrasi_detail",
                                "t_tvi_registrasi_detail.t_tvi_registrasi_id = t_tvi_registrasi.id")
                        ->where("t_tvi_registrasi.project_id", $project->id)
                        ->where("t_tvi_registrasi.active", 1)
                        ->where("t_tvi_registrasi.delete", 0)
                        ->order_by("t_tvi_registrasi.id")
                        ->get()->result();        
        return $data;
    }
    public function get_detail($id)
    {
        $this->load->model('m_core');
        $user_id = $this->m_core->user_id();
        $registrasi = $this->db->select("
                            'registrasi' as aktifitas,
                            FORMAT(tanggal_registrasi, 'dd/MM/yyyy') AS tanggal,
                            '' as keterangan")
                        ->from("t_tvi_registrasi")
                        ->where("id",$id)
                        ->get()->result();
        $aktifasi = $this->db->select("
                            'aktifasi' as aktifitas,
                            FORMAT(tanggal_aktifasi, 'dd/MM/yyyy hh:mm:ss') AS tanggal,
                            case status
                                when 1 then 'di Aktifkan'
                                else 'di Non Aktifkan'
                            end as keterangan")
                        ->from("t_tvi_aktifasi")
                        ->where("t_tvi_registrasi_id",$id)
                        ->get()->result();
        $data = array_merge($registrasi,$aktifasi);
        return $data;
    }
}
