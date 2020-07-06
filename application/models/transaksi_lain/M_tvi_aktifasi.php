<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_tvi_aktifasi extends CI_Model
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
        // $data = $this->db->select("
        //                             t_tvi_registrasi.*,
        //                             t_tvi_registrasi_detail.id,
        //                             t_tvi_registrasi_detail.unit,
        //                             t_tvi_registrasi_detail.customer_name,
        //                             t_tvi_registrasi_detail.isp_name,
        //                             t_tvi_registrasi_detail.paket_name,
        //                             t_tvi_registrasi_detail.create_user_name,
        //                             t_tvi_aktifasi_2.tanggal_aktifasi as tanggal_aktifasi,
        //                             isnull(t_tvi_aktifasi_2.status,0) as status
        //                         ")
        //     ->from("t_tvi_registrasi")
        //     ->join(
        //         "t_tvi_registrasi_detail",
        //         "t_tvi_registrasi_detail.t_tvi_registrasi_id = t_tvi_registrasi.id"
        //     )
        //     ->join(
        //         "
        //                     (SELECT
        //                             max(t_tvi_aktifasi.id) as id,
        //                             t_tvi_aktifasi.t_tvi_registrasi_id,
        //                             max(t_tvi_aktifasi.tanggal_aktifasi) as tanggal_aktifasi
        //                         FROM t_tvi_aktifasi
        //                         GROUP BY t_tvi_registrasi_id
        //                     ) as t_tvi_aktifasi_1",
        //         "t_tvi_aktifasi_1.t_tvi_registrasi_id = t_tvi_registrasi.id"
        //     )
        //     ->join(
        //         "t_tvi_aktifasi as t_tvi_aktifasi_2",
        //         "t_tvi_aktifasi_2.id = t_tvi_aktifasi_1.id"
        //     )
        //     ->where("t_tvi_registrasi.project_id", $project->id)
        //     ->where("t_tvi_registrasi.active", 1)
        //     ->where("t_tvi_registrasi.delete", 0)
        //     ->order_by("t_tvi_registrasi.id")
        //     ->get()->result();
        // echo("<pre>");
        //     print_r($data);
        // echo("</pre>");

        return $data;
    }
    public function action($id, $status)
    {
        $this->load->model('m_core');
        $user_id = $this->m_core->user_id();
        $this->db->insert("t_tvi_aktifasi", [
            "t_tvi_registrasi_id"   => $id,
            "tanggal_aktifasi"      => date("Y-m-d H:i:s.000"),
            "status"                => $status,
            "user_id"               => $user_id
        ]);
        $this->db->where("id",$id);
        $this->db->update("t_tvi_registrasi", [
            "status_aktifasi"                => $status
        ]);
        return true;
    }
}
