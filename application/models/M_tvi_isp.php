<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_tvi_isp extends CI_Model
{
    public function get()
    {
        $project = $this->m_core->project();
        return $this->db->from("m_tvi_isp")
                            ->where("active",1)
                            ->where("project_id",$project->id)
                            ->where("delete",0)
                            ->order_by("id", "desc")
                            ->get()->result();
    }
    public function save($data){
        $data = (object)$data;
        $project = $this->m_core->project();
        $validation = $this->db->from("m_tvi_isp")
                                ->where("project_id",$project->id)
                                ->where("delete",0)
                                ->where("active",1)
                                ->where("name",$data->name)
                                ->get()
                                ->num_rows();
        if($validation > 0)
            return false;
        else
            $this->db->insert("m_tvi_isp",[
                "name"                      => $data->name,
                "pembagian_hasil_1"         => $data->pembagian_hasil_1,
                "pembagian_hasil_2"         => $data->pembagian_hasil_2,
                "pembagian_pasang_baru_1"   => $data->pembagian_pasang_baru_1,
                "pembagian_pasang_baru_2"   => $data->pembagian_pasang_baru_2,
                "active"                    => 1,
                "delete"                    => 0,
                "description"               => $data->description,
                "project_id"                => $project->id
            ]);
            return true;
    }
    public function update($id,$data){
        $data = (object)$data;
        $project = $this->m_core->project();
        $validation = $this->db->from("m_tvi_isp")
                                ->where("project_id",$project->id)
                                ->where("delete",0)
                                ->where("active",1)
                                ->where("name",$data->name)
                                ->where("id !=",$id)
                                ->get()
                                ->num_rows();
        if($validation > 0)
            return false;
        else
            $this->db->where('id',$id);
            $this->db->update("m_tvi_isp",[
                "name"                      => $data->name,
                "pembagian_hasil_1"         => $data->pembagian_hasil_1,
                "pembagian_hasil_2"         => $data->pembagian_hasil_2,
                "pembagian_pasang_baru_1"   => $data->pembagian_pasang_baru_1,
                "pembagian_pasang_baru_2"   => $data->pembagian_pasang_baru_2,
                // "active"                    => 1,
                // "delete"                    => 0,
                "description"               => $data->description,
                "project_id"                => $project->id
            ]);
            return true;
    }
    public function delete($id){
        $project = $this->m_core->project();
        $this->db->where('id',$id);
        $this->db->update("m_tvi_isp",[
            "active"                    => 0,
            "delete"                    => 1
        ]);
        return true;
    }
}
