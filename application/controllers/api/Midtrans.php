<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Midtrans extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->load->database();
        $this->db->database = "ems.dbo";
    }
    public function index_get($api_key = null, $type = null)
    {
        $from = "ems.dbo";

        $uid = $this->input->get("uid");
        if (!$api_key) {
            $this->response(null, 401);
        } else {
            if ($api_key != 'sales_force_permission')
                $this->response(null, 401);
        }
        if (!$uid || !$type) {
            $this->response(null, 400); // OK (200) being the HTTP response code
        }

        $resultUnit = $this->db->select("kawasan.name as kawasan,
                                        blok.name as blok,
                                        project.name as project,
                                        unit.no_unit")
            ->from($from . "unit")
            ->join(
                $from . "project",
                "project.id = unit.project_id"
            )
            ->join(
                $from . "blok",
                "blok.id = unit.blok_id"
            )
            ->join(
                $from . "kawasan",
                "kawasan.id = blok.kawasan_id"
            )
            ->where("CONCAT(project.source_id,kawasan.code,blok.code,'/',unit.no_unit)", "$uid")
            ->get()->row();

        $total = (object)[];

        if ($type == "bill") {

            $total->tagihan_air = 0;
            $total->tagihan_lingkungan = 0;
            $total->tagihan_lain = 0;
            $total->total_denda = 0;
            $total->total = 0;
            $resultTMP = $this->db->select("
                                                uid,
                                                bill_id as tagihan_id,
                                                periode,
                                                tagihan_air,
                                                tagihan_lingkungan,
                                                tagihan_lain,
                                                total_denda, 
                                                isnull(tagihan_air,0)+
                                                isnull(tagihan_lingkungan,0)+
                                                isnull(tagihan_lain,0)+
                                                isnull(total_denda,0)
                                                as total
                        ")
                ->from($from . "v_sales_force_pending")
                ->where("uid", "$uid")
                ->order_by("periode")
                ->get()->result();
            foreach ($resultTMP as $key => $v) {
                $total->tagihan_air          += $v->tagihan_air;
                $total->tagihan_lingkungan   += $v->tagihan_lingkungan;
                $total->tagihan_lain         += $v->tagihan_lain;
                $total->total_denda          += $v->total_denda;
                $total->total                += $v->total;
            }
        } else if ($type == "history") {
            $total->tagihan_air = 0;
            $total->tagihan_lingkungan = 0;
            $total->tagihan_lain = 0;
            $total->total_denda = 0;
            $total->total = 0;
            $resultTMP = $this->db
                ->select("
                            uid,
                            bill_id as tagihan_id,
                            periode,
                            tagihan_air,
                            tagihan_lingkungan,
                            tagihan_lain,
                            total_denda, 
                            isnull(tagihan_air,0)+
                            isnull(tagihan_lingkungan,0)+
                            isnull(tagihan_lain,0)+
                            isnull(total_denda,0)
                            as total,
                            status_tagihan
                        ")
                ->from($from . "v_sales_force_history")
                ->where("uid", "$uid")
                ->order_by("periode")
                ->get()->result();
            foreach ($resultTMP as $key => $v) {
                $total->tagihan_air          += $v->tagihan_air;
                $total->tagihan_lingkungan   += $v->tagihan_lingkungan;
                $total->tagihan_lain         += $v->tagihan_lain;
                $total->total_denda          += $v->total_denda;
                $total->total                += $v->total;
            }
            // $result = $this->db->select("*")->from($from."v_xendit_history")->where("uid = $uid")->get()->result();
        } else
            $this->response(null, 400);

        // echo("<pre>");   
        //     print_r($project);
        // echo("</pre>");
        $result = (object)[];
        $result->info = (object)[];
        $result->info->project = $resultUnit->project;
        $result->info->kawasan = $resultUnit->kawasan;
        $result->info->blok = $resultUnit->blok;
        $result->info->no_unit = $resultUnit->no_unit;
        $result->total = $total;
        $result->tagihan = $resultTMP;
        // $result->info = $resultTMP;
        $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

    }

    public function index_post($api_key = null)
    {
        $this->load->helper('file');
        write_file("./log/" . date("y-m-d") . '_log_xendit.txt', "\n" . date("y-m-d h:i:s") . " = POST !" . json_encode($this->post()) . " !", 'a+');

        if ($this->post("transaction_status") == 'settlement') {
            $from = "ems.dbo.";
            $this->load->model('transaksi/m_pembayaran_xendit');
            $external_id    = $this->post("order_id") ? $this->post("order_id") : null; //a022u0000017gPoAAI
            $external_id = $this->db->select("external_id")
                ->from($from . "checkout_salesforce")
                ->where("salesforce_id", $external_id)
                ->get()->row(); // 7942744
            $external_id = $external_id ? $external_id->external_id : 0;
            $external_id_full = $external_id;
            $bank_code    = $this->post("va_numbers")[0]['bank']; //bca

            $external_id    = explode(";", $external_id);
            $cara_pembayaran    = $this->db
                ->select("cara_pembayaran.id,cara_pembayaran.project_id")
                ->from($from . "t_tagihan")
                ->join(
                    $from . "cara_pembayaran",
                    "cara_pembayaran.jenis_cara_pembayaran_id = 3
                                                AND cara_pembayaran.project_id = t_tagihan.proyek_id",
                    "LEFT"
                )
                ->join(
                    "bank",
                    "bank.id = cara_pembayaran.bank_id",
                    "LEFT"
                )
                ->join(
                    "bank_jenis",
                    "bank_jenis.id = bank.bank_jenis_id", //bca
                    "LEFT"
                )
                ->where("bank_jenis.code", $bank_code)
                ->where_in("t_tagihan.id", $external_id) //6927692
                ->order_by("bank_jenis.id", "DESC")
                ->get()->row();
            //sebelumnya where bank_jenis.code ada di join bank, sehingga menimbulkan bug 

            if (isset($cara_pembayaran->project_id)) {
                $project_id = $cara_pembayaran->project_id;
                $cara_pembayaran = $cara_pembayaran->id;
                $periode = date("Y-m-01");
                $tagihan_air = $this->db->select("
                                    CONCAT(service.id,'|',service.service_jenis_id,'|',v_tagihan_air.tagihan_id,'|',isnull(v_tagihan_air.total,0),'|',
                                    isnull(CASE
                                    WHEN service.denda_flag = 0 THEN 0
                                    WHEN v_tagihan_air.nilai_denda_flag = 1 THEN v_tagihan_air.nilai_denda 
                                    WHEN v_tagihan_air.periode > '$periode' THEN 0
                                        ELSE
                                        CASE					
                                            WHEN v_tagihan_air.denda_jenis_service = 1 
                                                THEN v_tagihan_air.denda_nilai_service 
                                            WHEN v_tagihan_air.denda_jenis_service = 2 
                                                THEN v_tagihan_air.denda_nilai_service *
                                                    (DateDiff
                                                        ( MONTH, DATEADD(month,service.denda_selisih_bulan,v_tagihan_air.periode), '$periode' ) 
                                                        + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) 
                                                    )
                                            WHEN v_tagihan_air.denda_jenis_service = 3 
                                                THEN 
                                                    (v_tagihan_air.denda_nilai_service* v_tagihan_air.total/ 100 ) 
                                                    * (DateDiff( MONTH, v_tagihan_air.periode, '$periode' ) 
                                                    + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
                                        END 
                                    END,0),'|',0,'|',
                                    0,'|',
                                    0) as tagihan")
                    ->from($from . "v_tagihan_air")
                    ->join(
                        $from . "service",
                        "service.project_id = $project_id
                    AND service.service_jenis_id = 2
                    AND service.active = 1
                    AND service.delete = 0"
                    )
                    ->where("v_tagihan_air.status_tagihan = 3")
                    ->where_in("v_tagihan_air.t_tagihan_id", $external_id)
                    ->get()->result();
                $tagihan_lingkungan = $this->db->select("
                                    CONCAT(service.id,'|',service.service_jenis_id,'|',v_tagihan_lingkungan.tagihan_id,'|',isnull(v_tagihan_lingkungan.total,0),'|',
                                    isnull(CASE
                                        WHEN v_tagihan_lingkungan.periode <= unit_lingkungan.tgl_mulai_denda THEN
                                            CASE
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 1 
                                                    THEN v_tagihan_lingkungan.denda_nilai_service 
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 2 
                                                    THEN 
                                                        v_tagihan_lingkungan.denda_nilai_service * 
                                                            (DateDiff
                                                                ( MONTH, unit_lingkungan.tgl_mulai_denda, '$periode' ) 
                                                                + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) 
                                                            )
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 3 
                                                    THEN 
                                                        ( v_tagihan_lingkungan.denda_nilai_service * v_tagihan_lingkungan.total/ 100 ) 
                                                        * (DateDiff( MONTH, unit_lingkungan.tgl_mulai_denda, '$periode' ) 
                                                        + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
                                            END 	
                                        WHEN v_tagihan_lingkungan.nilai_denda_flag = 1 THEN v_tagihan_lingkungan.nilai_denda 
                                        WHEN v_tagihan_lingkungan.periode > '$periode' THEN 0
                                        ELSE
                                            CASE
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 1 
                                                    THEN v_tagihan_lingkungan.denda_nilai_service 
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 2 
                                                    THEN v_tagihan_lingkungan.denda_nilai_service * 
                                                        (DateDiff
                                                            ( MONTH, DATEADD(MONTH, service.denda_selisih_bulan, v_tagihan_lingkungan.periode), '$periode' ) 
                                                            + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) 
                                                        )
                                                WHEN v_tagihan_lingkungan.denda_jenis_service = 3 
                                                    THEN 
                                                        ( v_tagihan_lingkungan.denda_nilai_service * v_tagihan_lingkungan.total/ 100 ) 
                                                        * (DateDiff( MONTH, v_tagihan_lingkungan.periode, '$periode' ) 
                                                        + IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
                                            END 
                                        END,0),'|',0,'|',
                                    0,'|',
                                    0) as tagihan")
                    ->from($from . "v_tagihan_lingkungan")
                    ->join(
                        $from . "service",
                        "service.project_id = $project_id
                    AND service.service_jenis_id = 1
                    AND service.active = 1
                    AND service.delete = 0"
                    )
                    ->join(
                        $from . "unit_lingkungan",
                        "unit_lingkungan.unit_id = v_tagihan_lingkungan.unit_id"
                    )
                    ->where("v_tagihan_lingkungan.status_tagihan = 3")
                    ->where_in("v_tagihan_lingkungan.t_tagihan_id", $external_id)

                    ->get()->result();
                $tagihan = [];
                foreach ($tagihan_air as $k => $v) {
                    array_push($tagihan, $v->tagihan);
                }
                foreach ($tagihan_lingkungan as $k => $v) {
                    array_push($tagihan, $v->tagihan);
                }
                if (!$tagihan) {
                    $message = [
                        'message' => implode(",", $external_id) . "- Failed"
                    ];
                    $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                    return;
                }
                $success = 0;

                $unit_id = $this->db->select("*")
                    ->from($from . "t_tagihan")
                    ->where_in("id", $external_id)
                    ->get()->row()->unit_id;

                if ($this->m_pembayaran_xendit->save($tagihan, null, $unit_id, $cara_pembayaran, $project_id, 0, 0, date("d/m/Y")))
                    $success++;
                if (!$api_key) {
                    $this->response(null, 401);
                } else {
                    if ($api_key != 'midtrans_permission')
                        $this->response(null, 401);
                }
                $this->load->library('curl');
                $dataApi = [
                    "grant_type"    => "password",
                    "client_id"     => "3MVG9G9pzCUSkzZvdA4eKm_jdVZVXQ5U2c0L6gyvdnC.WqwoLIqfj2j8vfExyjTTvNQBdogzzrCLuPpkdmgbt",
                    "client_secret" => "C823D7F2BFC8688FF1ADF9A0B8873EFECD9D2F22E85C2538127458A2FCB16F88",
                    "username"      => "ciputrapropertyy-cisv@force.com",
                    "password"      => "Salesforce2019ZSq9OdbkPDFtmqNvOqDIdBhZ8"
                ];
                $this->load->helper('file');
                write_file("./log/" . date("y-m-d") . '_log_xendit_to_salesforce.txt', "\n" . date("y-m-d h:i:s") . " = POST (Get Key) !" . json_encode($dataApi) . " !", 'a+');
                $keySF = json_decode($this->curl->simple_post("https://login.salesforce.com/services/oauth2/token", $dataApi));
                $checkout_data = $this->db->select("*")
                    ->from($from . "checkout_salesforce")
                    ->where("external_id", $external_id_full)
                    ->where("bank_code", $bank_code)
                    // ->where("xendit_id",$midtrans_id)
                    ->order_by("id", "DESC")
                    ->get()->row();
                if ($checkout_data->salesforce_id) {
                    $dateZ = new DateTime(date("Y-m-d H:i:s"), new DateTimeZone("Asia/Jakarta"));
                    $dateZ->setTimezone(new DateTimeZone('UTC'));
                    $WaktuZulu = $dateZ->format("Y-m-d") . "T" . $dateZ->format("H:i:s.000") . "Z";
                    $data = [
                        "Status__c"     => "Paid",
                        "Paid_Date__c"  => $WaktuZulu
                    ];
                    $data_string = json_encode($data);
                    $this->load->helper('file');
                    write_file("./log/" . date("y-m-d") . '_log_midtrans_to_salesforce.txt', "\n" . date("y-m-d h:i:s") . " = POST !" . json_encode($data_string) . " !", 'a+');
                    $ch = curl_init("https://ciputra-sh1.my.salesforce.com/services/data/v46.0/sobjects/Checkout_Invoice__c/$checkout_data->salesforce_id?_HttpMethod=PATCH");
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data_string),
                            "Authorization: Bearer $keySF->access_token"
                        )
                    );
                    $result = curl_exec($ch);

                    if ($success > 0)
                        $message = [
                            'message' => implode(",", $external_id) . "- Success"
                        ];
                    else
                        $message = [
                            'message' => implode(",", $external_id) . "- Failed "
                        ];
                } else {
                    $message = [
                        'message' => implode(",", $external_id) . "- Failed : Data Check Out tidak ada"
                    ];
                }
            } else {
                $message = [
                    'message' => implode(",", $external_id) . "- Failed : Cara Pembayaran"
                ];
            }
            $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
    }

    public function users_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }
}
