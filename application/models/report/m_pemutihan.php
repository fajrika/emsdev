<?php

defined("BASEPATH") or exit("No direct script access allowed");

class m_pemutihan extends CI_Model
{
    public function getListPemutihan($project_id)
    {
        return $this->db
                        ->select("pemutihan.id,
                            pemutihan.code,
                            pemutihan.masa_awal,
                            pemutihan.masa_akhir,
                            (pemutihan_nilai.perkiraan_pemutihan_nilai_tagihan + pemutihan_nilai.perkiraan_pemutihan_nilai_denda) as perkiraan_total,
                            CASE pemutihan.status
                                WHEN 0 THEN 'Pending'
                                WHEN 1 THEN 'Approve'
                                WHEN 2 THEN 'Reject'
                            END as status")
                        ->from("pemutihan")
                        ->join("pemutihan_nilai",
                                "pemutihan_nilai.pemutihan_id = pemutihan.id")
                        ->join("approval",
                                "approval.id = pemutihan.approval_id",
                                "LEFT")
                        ->where("pemutihan.project_id",$project_id)
                        ->get()->result();
    }
    public function getListDetailPemutihan($pemutihan_id){
        return $this->db
                        ->select("kawasan.name as kawasan,
                        blok.name as blok,
                        unit.no_unit,
                        customer.name as customer,
                        periode,
                        pemutihan_nilai_tagihan,
                        pemutihan_nilai_denda,
                        case service_jenis_id
                            WHEN 1 then 'IPL'
                            ELSE 'AIR'
                        END as service")
                        ->from("pemutihan")
                        ->join("pemutihan_unit",
                                "pemutihan_unit.pemutihan_id = pemutihan.id")
                        ->join("unit",
                                "unit.id = pemutihan_unit.unit_id")
                        ->join("blok",
                                "blok.id = unit.blok_id")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id")
                        ->join("customer",
                                "customer.id = unit.pemilik_customer_id")
                        ->where("pemutihan.id",$pemutihan_id)
                        ->get()->result();
    }
    
}