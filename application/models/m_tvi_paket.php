<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_tvi_paket extends CI_Model
{
    public function get()
    {
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
                        ->where("m_tvi_paket.delete",0)
                        ->order_by("m_tvi_paket.id", "desc")
                        ->get()->result();
    }
    public function save($data){
        $data = (object)$data;
        $project = $this->m_core->project();
        $validation = $this->db->from("m_tvi_paket")
                                ->join("m_tvi_isp",
                                        "m_tvi_isp.id = m_tvi_paket.m_tvi_isp_id")
                                ->where("m_tvi_paket.project_id",$project->id)
                                ->where("m_tvi_paket.delete",0)
                                ->where("m_tvi_paket.active",1)
                                ->where("m_tvi_paket.name",$data->name)
                                ->where("m_tvi_isp.id",$data->isp_id)
                                
                                ->get()
                                ->num_rows();
        if($validation > 0)
            return false;
        else
            $this->db->insert("m_tvi_paket",[
                "m_tvi_isp_id" => $data->isp_id,
                "name" => $data->name,
                "harga" => $data->harga,
                "harga_pasang_baru" => $data->harga_pasang_baru,
                "durasi" => $data->durasi,
                "tipe_durasi" => $data->tipe_durasi,
                "active" => 1,
                "delete" => 0,
                "project_id" => $project->id,
                "bandwidth" => $data->bandwidth,
                "description" => $data->description,
            ]);
            return true;
    }
    public function update($id,$data){
        $data = (object)$data;
        $project = $this->m_core->project();
        $validation = $this->db->from("m_tvi_paket")
                                ->where("project_id",$project->id)
                                ->where("delete",0)
                                ->where("active",1)
                                ->where("name",$data->name)
                                ->where("id !=",$id)
                                ->where("m_tvi_isp_id",$data->isp_id)
                                ->get()
                                ->num_rows();
        if($validation > 0)
            return false;
        else
            $this->db->where('id',$id);
            $this->db->update("m_tvi_paket",[
                "m_tvi_isp_id"  => $data->isp_id,
                "name"          => $data->name,
                "harga"         => $data->harga,
                "harga_pasang_baru"   => $data->harga_pasang_baru,
                "durasi"        => $data->durasi,
                "tipe_durasi"   => $data->tipe_durasi,
                // "active"     => 1,
                // "delete"     => 0,
                "project_id"    => $project->id,
                "bandwidth"     => $data->bandwidth,
                "description"   => $data->description,
            ]);
        return true;
    }
    public function delete($id){
        $project = $this->m_core->project();
        $this->db->where('id',$id);
        $this->db->update("m_tvi_paket",[
            "active"                    => 0,
            "delete"                    => 1
        ]);
        return true;
    }
}
