<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_desktop_transaksi_lingkungan extends CI_Model
{
    public function save_lingkungan($project_id, $source, $denda_jenis_service, $denda_nilai_service, $jarak_periode = 0)
    {
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $user_id = $this->db->SELECT("id")
            ->from("user")
            ->where("username", $username)
            ->where("password", $password)
            ->get()->row();
        $user_id = $user_id ? $user_id->id : 0;
        $tagihan_lingkungan_tmp =
            $this->db
            ->select("                                                    
                t_tagihan.id as t_tagihan_id,
                t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id as tagihan_id,

                DATEADD(MONTH,$jarak_periode,td_lingkungan.periode) as lingkungan_periode,
                
                isnull(td_lingkungan.nilai_keamanan,0) as lingkungan_keamanan,
                isnull(td_lingkungan.nilai_sampah,0) as lingkungan_kebersihan,
                isnull(td_lingkungan.nilai_ppn,0) as lingkungan_ppn,
                isnull(td_lingkungan.nilai_tanah,0) as nilai_tanah,
                isnull(td_lingkungan.nilai_bangunan,0) as nilai_bangunan,
                isnull(td_lingkungan.nomor,0) as lingkungan_kode_tagihan,
                isnull(td_lingkungan.nilai_denda,0) as lingkungan_denda,
                isnull(td_lingkungan.nilai_ppn,0) as lingkungan_ppn,

                td_lingkungan.td_lingkungan_id,
                td_lingkungan.tanggal_bayar as lingkungan_bayar,
                unit.id as unit_id,
                sub_golongan.id as sub_gol_id,
                sub_golongan.code as sub_gol_code,
                range_lingkungan.id as range_id,
                range_lingkungan.code as range_code,
                unit.luas_bangunan,
                unit.luas_tanah")
            ->from("ems_temp.$source.td_lingkungan")
            ->join(
                "ems_temp.$source.th_trans",
                "th_trans.th_trans_id = td_lingkungan.th_trans_id",
                "LEFT"
            )
            ->join(
                "unit",
                "unit.source_table = '$source'
                AND unit.source_id = th_trans.cust_id"
            )
            ->join(
                "unit_lingkungan",
                "on unit_lingkungan.unit_id = unit.id"
            )
            ->join(
                "sub_golongan",
                "sub_golongan.id = unit_lingkungan.sub_gol_id"
            )
            ->join(
                "range_lingkungan",
                "range_lingkungan.id = sub_golongan.range_id"
            )
            ->join(
                "t_tagihan",
                "t_tagihan.proyek_id = '$project_id' 
                AND t_tagihan.unit_id = unit.id
                AND t_tagihan.periode = CONVERT(date,DATEADD(MONTH,1,FORMAT(td_lingkungan.periode,'yyyy-MM-01')))",
                "LEFT"
            )
            ->join(
                "t_tagihan_lingkungan_detail",
                "t_tagihan_lingkungan_detail.source_id = concat('IPL - ',td_lingkungan.td_lingkungan_id)
                AND t_tagihan_lingkungan_detail.source_table = '$source'",
                "LEFT"
            )
            ->where("t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id is null")
            // ->limit("10")
            ->get()->result();

        $tagihan_lingkungan         = (object)[];
        $tagihan_lingkungan_detail  = (object)[];
        $tagihan_lingkungan_info    = (object)[];
        $data_tagihan               = (object)[];

        $tagihan_lingkungan->proyek_id                  = $project_id;
        $tagihan_lingkungan_detail->source_table        = $source;
        $tagihan_lingkungan_detail->active              = 1;
        $tagihan_lingkungan_detail->user_id             = $user_id;
        $tagihan_lingkungan_detail->nilai_ppn           = 10;
        $tagihan_lingkungan_detail->nilai_bangunan_flag = 0;
        $tagihan_lingkungan_detail->nilai_kavling_flag  = 0;
        $tagihan_lingkungan_detail->nilai_denda_flag    = 0;
        $tagihan_lingkungan_detail->ppn_sc_flag         = 0;
        $tagihan_lingkungan_info->formula_bangunan      = 9;
        $tagihan_lingkungan_info->formula_kavling       = 9;
        $data_tagihan->proyek_id                        = $project_id;

        $i = 0;

        foreach ($tagihan_lingkungan_tmp as $k => $v) {
            $this->db->trans_begin();

            $tagihan_lingkungan->unit_id = $v->unit_id;
            $tagihan_lingkungan->periode        = $v->lingkungan_periode ? substr($v->lingkungan_periode, 0, 8) . "01" : null;
            $tagihan_lingkungan->kode_tagihan   = $v->lingkungan_kode_tagihan;
            $tagihan_lingkungan->status_tagihan = $v->lingkungan_bayar ? 1 : 0;

            $double = $v->tagihan_id ? 1 : 0;

            if ($double == 0) {

                if (!$v->t_tagihan_id) {
                    $data_tagihan->unit_id      = $tagihan_lingkungan->unit_id;
                    $data_tagihan->periode      = $tagihan_lingkungan->periode;

                    $this->db->insert('t_tagihan', $data_tagihan);

                    $tagihan_lingkungan->t_tagihan_id = $this->db->insert_id();
                } else {
                    $tagihan_lingkungan->t_tagihan_id = $v->t_tagihan_id;
                }
                $i++;
                $this->db->insert("t_tagihan_lingkungan", $tagihan_lingkungan);

                $tagihan_lingkungan_detail->t_tagihan_lingkungan_id = $this->db->insert_id();
                $tagihan_lingkungan_detail->source_id           = "IPL - " . $v->td_lingkungan_id;
                $tagihan_lingkungan_detail->nilai_bangunan      = $v->nilai_bangunan;
                $tagihan_lingkungan_detail->nilai_kavling       = $v->nilai_tanah;
                $tagihan_lingkungan_detail->nilai_administrasi  = 0;
                $tagihan_lingkungan_detail->nilai_keamanan      = $v->lingkungan_keamanan;
                $tagihan_lingkungan_detail->nilai_kebersihan    = $v->lingkungan_kebersihan;
                $tagihan_lingkungan_detail->nilai_denda         = $v->lingkungan_denda;
                $tagihan_lingkungan_detail->ppn_flag            = $v->lingkungan_ppn ? 1 : 0;

                $tagihan_lingkungan_info->t_tagihan_lingkungan_id   = $tagihan_lingkungan_detail->t_tagihan_lingkungan_id;
                $tagihan_lingkungan_info->range_id                  = $v->range_id;
                $tagihan_lingkungan_info->range_code                = $v->range_code;
                $tagihan_lingkungan_info->sub_golongan_id           = $v->sub_gol_id;
                $tagihan_lingkungan_info->sub_golongan_code         = $v->sub_gol_code;
                $tagihan_lingkungan_info->luas_bangunan             = $v->luas_bangunan;
                $tagihan_lingkungan_info->luas_kavling              = $v->luas_tanah;
                $tagihan_lingkungan_info->denda_jenis_service       = $denda_jenis_service;
                $tagihan_lingkungan_info->denda_nilai_service       = $denda_nilai_service;

                $this->db->insert("t_tagihan_lingkungan_detail", $tagihan_lingkungan_detail);
                $this->db->insert("t_tagihan_lingkungan_info", $tagihan_lingkungan_info);
            }
            $this->db->trans_commit();
        }

        echo (json_encode($i));
    }
    public function save_air($project_id, $source, $denda_jenis_service, $denda_nilai_service, $jarak_periode = 0)
    {
        // die;
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $user_id = $this->db->SELECT("id")
            ->from("user")
            ->where("username", $username)
            ->where("password", $password)
            ->get()->row();
        $user_id = $user_id ? $user_id->id : 0;
        $tagihan_lingkungan_tmp = $this->db->select("
                                                    t_tagihan.id as t_tagihan_id,
                                                    t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id as tagihan_id,
                                                    
                                                    DATEADD(MONTH,$jarak_periode,td_air.periode) as air_periode,
                                                    
                                                    isnull(td_air.nilai_keamanan,0) as air_keamanan, 
                                                    isnull(td_air.nilai_sampah,0) as air_kebersihan,
                                                    isnull(td_air.nilai_ppnkeamanan,0) as air_keamanan_ppn,
                                                    isnull(td_air.nilai_ppnkebersihan,0) as air_kebersihan_ppn,
                                                    isnull(td_air.nomor,0) as air_kode_tagihan,
                                                    isnull(td_air.nilai_denda,0) as air_denda,
                                                    isnull(td_air.nilai_ppnkebersihan + td_air.nilai_ppnkeamanan,0) as air_ppn,
                                                    td_air.tanggal_bayar as air_bayar,
                                                    

                                                    td_air.td_air_id,
                                                    unit.id as unit_id,
                                                    sub_golongan.id as sub_gol_id,
                                                    sub_golongan.code as sub_gol_code,
                                                    range_lingkungan.id as range_id,
                                                    range_lingkungan.code as range_code,
                                                    unit.luas_bangunan,
                                                    unit.luas_tanah")
            ->from("ems_temp.$source.td_air")
            ->join(
                "ems_temp.$source.th_trans",
                "th_trans.th_trans_id = td_air.th_trans_id",
                "LEFT"
            )
            ->join(
                "unit",
                "unit.source_table = '$source'
                                                    AND unit.source_id = th_trans.cust_id"
            )
            ->join(
                "unit_lingkungan",
                "on unit_lingkungan.unit_id = unit.id"
            )
            ->join(
                "sub_golongan",
                "sub_golongan.id = unit_lingkungan.sub_gol_id"
            )
            ->join(
                "range_lingkungan",
                "range_lingkungan.id = sub_golongan.range_id"
            )
            ->join(
                "t_tagihan",
                "t_tagihan.proyek_id = '$project_id' 
                                                    AND t_tagihan.unit_id = unit.id
                                                    AND t_tagihan.periode = CONVERT(date,DATEADD(MONTH,1,FORMAT(td_air.periode,'yyyy-MM-01')))",
                "LEFT"
            )
            ->join(
                "t_tagihan_lingkungan_detail",
                "t_tagihan_lingkungan_detail.source_id = concat('AIR - ',td_air.td_air_id)
                                                    AND t_tagihan_lingkungan_detail.source_table = '$source'",
                "LEFT"
            )

            ->where("t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id is null")
            ->where("(isnull(td_air.nilai_keamanan,0) +isnull(td_air.nilai_sampah,0) + isnull(td_air.nilai_ppnkeamanan,0) + isnull(td_air.nilai_ppnkebersihan,0)) != 0")

            ->get()->result();

        $tagihan_lingkungan         = (object)[];
        $tagihan_lingkungan_detail  = (object)[];
        $tagihan_lingkungan_info    = (object)[];
        $data_tagihan               = (object)[];



        $tagihan_lingkungan->proyek_id                  = $project_id;
        $tagihan_lingkungan_detail->source_table        = $source;
        $tagihan_lingkungan_detail->active              = 1;
        $tagihan_lingkungan_detail->user_id             = $user_id;
        $tagihan_lingkungan_detail->nilai_ppn           = 10;
        $tagihan_lingkungan_detail->nilai_bangunan_flag = 0;
        $tagihan_lingkungan_detail->nilai_kavling_flag  = 0;
        $tagihan_lingkungan_detail->nilai_denda_flag    = 0;
        $tagihan_lingkungan_detail->ppn_sc_flag         = 0;
        $tagihan_lingkungan_info->formula_bangunan      = 9;
        $tagihan_lingkungan_info->formula_kavling       = 9;
        $data_tagihan->proyek_id                        = $project_id;

        $i = 0;

        foreach ($tagihan_lingkungan_tmp as $k => $v) {
            $this->db->trans_begin();

            $tagihan_lingkungan->unit_id = $v->unit_id;

            $tagihan_lingkungan->periode        = $v->air_periode ? substr($v->air_periode, 0, 8) . "01" : null;
            $tagihan_lingkungan->kode_tagihan   = $v->air_kode_tagihan;
            $tagihan_lingkungan->status_tagihan = $v->air_bayar ? 1 : 0;
            $double = $v->tagihan_id ? 1 : 0;

            if ($double == 0) {



                if (!$v->t_tagihan_id) {
                    $data_tagihan->unit_id      = $tagihan_lingkungan->unit_id;
                    $data_tagihan->periode      = $tagihan_lingkungan->periode;

                    $this->db->insert('t_tagihan', $data_tagihan);

                    $tagihan_lingkungan->t_tagihan_id = $this->db->insert_id();
                } else {
                    $tagihan_lingkungan->t_tagihan_id = $v->t_tagihan_id;
                }

                $i++;
                $this->db->insert("t_tagihan_lingkungan", $tagihan_lingkungan);

                $tagihan_lingkungan_detail->t_tagihan_lingkungan_id = $this->db->insert_id();

                $tagihan_lingkungan_detail->source_id           = "AIR - " . $v->td_air_id;
                $tagihan_lingkungan_detail->nilai_bangunan      = 0;
                $tagihan_lingkungan_detail->nilai_kavling       = 0;
                $tagihan_lingkungan_detail->nilai_administrasi  = 0;
                $tagihan_lingkungan_detail->nilai_keamanan      = $v->air_keamanan;
                $tagihan_lingkungan_detail->nilai_kebersihan    = $v->air_kebersihan;
                $tagihan_lingkungan_detail->nilai_denda         = $v->air_denda;
                $tagihan_lingkungan_detail->ppn_flag            = $v->air_ppn ? 1 : 0;
                $tagihan_lingkungan_info->t_tagihan_lingkungan_id   = $tagihan_lingkungan_detail->t_tagihan_lingkungan_id;
                $tagihan_lingkungan_info->range_id                  = $v->range_id;
                $tagihan_lingkungan_info->range_code                = $v->range_code;
                $tagihan_lingkungan_info->sub_golongan_id           = $v->sub_gol_id;
                $tagihan_lingkungan_info->sub_golongan_code         = $v->sub_gol_code;
                $tagihan_lingkungan_info->luas_bangunan             = $v->luas_bangunan;
                $tagihan_lingkungan_info->luas_kavling              = $v->luas_tanah;
                $tagihan_lingkungan_info->denda_jenis_service       = $denda_jenis_service;
                $tagihan_lingkungan_info->denda_nilai_service       = $denda_nilai_service;

                $this->db->insert("t_tagihan_lingkungan_detail", $tagihan_lingkungan_detail);
                $this->db->insert("t_tagihan_lingkungan_info", $tagihan_lingkungan_info);
            }
            $this->db->trans_commit();
        }
        // echo(0);
        echo (json_encode($i));
    }
}
