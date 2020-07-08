<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

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
class Sales_force extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->load->database();
        $this->db->database = "ems";

    }
    public function index_post($api_key=null,$type=null){
        $this->load->helper('file');
        write_file("./log/".date("y-m-d").'_log_salesforce.txt',"\n".date("y-m-d h:i:s")." = POST !".json_encode($this->post())." !", 'a+');

        $from = "ems.dbo";
        if(!$api_key){
            $this->response(null,401);
        }else{
            if($api_key != 'sales_force_permission')
                $this->response(null,401);
        }
        $external_id    = $this->post("external_id");
        $data_checkout_sf = [
            "salesforce_id" => $this->post("salesforce_id"),
            "external_id"   => $this->post("external_id"),
            "bank_code"     => $this->post("bank_code"),
            "status"        => $this->post("status"),
            "xendit_id"     => $this->post("xendit_id"),
            "create_date"   => date("Y-m-d H:i:s.000")

        ];
        $this->db->insert("$from.checkout_salesforce",$data_checkout_sf);
        $external_id    = explode(";", $external_id);
        $tagihan = $this->db
                            ->select("
                                isnull(t_tagihan_lingkungan.id,0) as lingkungan_id,
                                isnull(t_tagihan_air.id,0) as air_id")
                            ->from("$from.v_sales_force_bill")
                            ->join("$from.t_tagihan_lingkungan",
                                    "t_tagihan_lingkungan.t_tagihan_id = v_sales_force_bill.bill_id
                                    AND t_tagihan_lingkungan.status_tagihan != 1",
                                    "LEFT")
                            ->join("$from.t_tagihan_air",
                                    "t_tagihan_air.t_tagihan_id = v_sales_force_bill.bill_id
                                    AND t_tagihan_air.status_tagihan != 1",
                                    "LEFT")
                            ->where_in("bill_id",$external_id)
                            ->get()->result();
        foreach ($tagihan as $v) {
            if($v->lingkungan_id != 0){
                $this->db->set('status_tagihan', 3);
                $this->db->where('id', $v->lingkungan_id);
                $this->db->update("$from.t_tagihan_lingkungan");
            }
            if($v->air_id != 0){
                $this->db->set('status_tagihan', 3);
                $this->db->where('id', $v->air_id);
                $this->db->update("$from.t_tagihan_air");
            }
        }

        $message = [
            'status' => "sukses", // Automatically generated by the model
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }
    public function exp_post($api_key=null,$type=null){
        $this->load->helper('file');
        write_file("./log/".date("y-m-d").'_log_salesforce.txt',"\n".date("y-m-d h:i:s")." = Expired POST !".json_encode($this->post())." !", 'a+');

        $from = "ems.dbo";
        if(!$api_key){
            $this->response(null,401);
        }else{
            if($api_key != '8hfjnfbj31nibHIasBUFB12125nvdonfbi')
                $this->response(null,401);
        }
        $external_id    = $this->post("external_id");
        $data_checkout_sf = [
            "salesforce_id" => $this->post("salesforce_id"),
            "external_id"   => $this->post("external_id"),
            "bank_code"     => $this->post("bank_code"),
            "status"        => $this->post("status"),
            "xendit_id"     => $this->post("xendit_id"),
            "create_date"   => date("Y-m-d H:i:s.000")

        ];
        $this->db->insert("$from.checkout_salesforce",$data_checkout_sf);
        $external_id    = explode(";", $external_id);
        // $tagihan = $this->db
        //                     ->select("
        //                         isnull(t_tagihan_lingkungan.id,0) as lingkungan_id,
        //                         isnull(t_tagihan_air.id,0) as air_id")
        //                     ->from("$from.v_sales_force_bill")
        //                     ->join("$from.t_tagihan_lingkungan",
        //                             "t_tagihan_lingkungan.t_tagihan_id = v_sales_force_bill.bill_id
        //                             AND t_tagihan_lingkungan.status_tagihan != 1",
        //                             "LEFT")
        //                     ->join("$from.t_tagihan_air",
        //                             "t_tagihan_air.t_tagihan_id = v_sales_force_bill.bill_id
        //                             AND t_tagihan_air.status_tagihan != 1",
        //                             "LEFT")
        //                     ->where_in("bill_id",$external_id)
        //                     ->get()->result();
        
        $this->db->set('status_tagihan', 0);
        $this->db->where_in("t_tagihan_lingkungan.t_tagihan_id",$external_id);
        $this->db->where("t_tagihan_lingkungan.status_tagihan",3);
        $this->db->update("$from.t_tagihan_lingkungan");

        $this->db->set('status_tagihan', 0);
        $this->db->where_in("t_tagihan_air.t_tagihan_id",$external_id);
        $this->db->where("t_tagihan_air.status_tagihan",3);
        $this->db->update("$from.t_tagihan_air");

        // foreach ($tagihan as $v) {
        //     if($v->lingkungan_id != 0){
        //         $this->db->set('status_tagihan', 0);
        //         $this->db->where('id', $v->lingkungan_id);
        //         $this->db->update("$from.t_tagihan_lingkungan");
        //     }
        //     if($v->air_id != 0){
        //         $this->db->set('status_tagihan', 0);
        //         $this->db->where('id', $v->air_id);
        //         $this->db->update("$from.t_tagihan_air");
        //     }
        // }

        $message = [
            'status' => "sukses", // Automatically generated by the model
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    public function expall_post($api_key=null,$type=null){
        $this->load->helper('file');
        write_file("./log/".date("y-m-d").'_log_salesforce.txt',"\n".date("y-m-d h:i:s")." = Expired All POST !".json_encode($this->post())." !", 'a+');

        $from = "ems.dbo";
        if(!$api_key){
            $this->response(null,401);
        }else{
            if($api_key != '98275hi93hd77e73h3h8fjehHJBAF8h88')
                $this->response(null,401);
        }
        $this->db->set('status_tagihan',0);
        $this->db->where('status_tagihan',3);
        $this->db->update("$from.t_tagihan_air");

        $this->db->set('status_tagihan',0);
        $this->db->where('status_tagihan',3);
        $this->db->update("$from.t_tagihan_lingkungan");

        $message = [
            'status' => "sukses", // Automatically generated by the model
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    public function index_get($api_key=null,$type=null)
    {
        $this->load->helper('file');
        write_file("./log/".date("y-m-d").'_log_salesforce.txt',"\n".date("y-m-d h:i:s")." = GET !".json_encode($this->input->get("uid"))." !", 'a+');

        $this->load->database();

        $from = "ems.dbo";
        $this->load->model("core/m_tagihan");
        // echo("<pre>");
        //     print_r($this->db);
        // echo("</pre>");

        $result = (object)[];

        $uid = $this->input->get("uid");
        if(!$api_key){
            $this->response(null,401);
        }else{
            if($api_key != 'sales_force_permission')
                $this->response(null,401);
        }
        if(!$uid || !$type){
            $this->response(null,400); // OK (200) being the HTTP response code
        }
        
        $resultUnit = $this->db->select("
                                        unit.id as unit_id,
                                        kawasan.name as kawasan,
                                        blok.name as blok,
                                        project.name as project,
                                        unit.no_unit,
                                        xendit_sub_account.sub_account as xendit,
                                        pt_apikey.apikey as midtrans
                                        ")
                                ->from("unit")
                                ->join('pt_apikey',
                                        'pt_apikey.pt_id = unit.pt_id',
                                        "LEFT")
                                ->join("project",
                                        "project.id = unit.project_id")
                                ->join("blok",
                                        "blok.id = unit.blok_id")
                                ->join("kawasan",
                                        "kawasan.id = blok.kawasan_id")
                                ->join("xendit_sub_account",
                                        "xendit_sub_account.project_id = unit.project_id
                                        AND xendit_sub_account.pt_id = unit.pt_id",
                                        "LEFT")
                                ->where("CONCAT(project.source_id,kawasan.code,blok.code,'/',unit.no_unit)","$uid")
                                // ->order_by("")
                                ->get()->row();

        
        $total = (object)[];

        if($type == "bill"){
            $param = [
                'unit_id' => $resultUnit->unit_id,
                'status_tagihan' => 0
            ];
            $tagihans = $this->m_tagihan->get_tagihan_gabungan($param,date("Y-m-d"));

            $total->tagihan_air = 0;
            $total->tagihan_lingkungan = 0;
            $total->tagihan_lain = 0;
            $total->total_denda = 0;
            $total->total = 0;

            $result->va = $this->m_tagihan->get_va($resultUnit->unit_id);
            $result->tagihan = [];
            foreach ($tagihans as $key => $tagihan) {
                if(isset($tagihan->air->final_total))
                    $total->tagihan_air += $tagihan->air->final_total;
                if(isset($tagihan->lingkungan->final_total))
                    $total->tagihan_lingkungan += $tagihan->lingkungan->final_total;
                
                $total->tagihan_lain         += 0;

                if(isset($tagihan->air->nilai_denda))
                    $total->total_denda += $tagihan->air->nilai_denda;
                if(isset($tagihan->lingkungan->nilai_denda))
                    $total->total_denda += $tagihan->lingkungan->nilai_denda;

                if(isset($tagihan->lingkungan->id)){
                    $tagihan_id = $tagihan->lingkungan->id;
                    $periode = $tagihan->lingkungan->periode;
                }elseif(isset($tagihan->air->id)){
                    $tagihan_id = $tagihan->air->id;
                    $periode = $tagihan->air->periode;
                }
                $tagihan_air = isset($tagihan->air->final_total)?$tagihan->air->final_total:0;
                $tagihan_lingkungan = isset($tagihan->lingkungan->final_total)?$tagihan->lingkungan->final_total:0;
                $total_denda = isset($tagihan->air->final_nilai_denda)?$tagihan->air->final_nilai_denda:0
                                    +isset($tagihan->lingkungan->final_nilai_denda)?$tagihan->lingkungan->final_nilai_denda:0;
                    
                array_push($result->tagihan,(object)[
                    "uid" => $uid,
                    "tagihan_id" => $tagihan_id,
                    "periode" => $periode,
                    "tagihan_air" => $tagihan_air,
                    "tagihan_lingkungan" => $tagihan_lingkungan,
                    "tagihan_lain" => 0,
                    "total_denda" => $total_denda,
                    "total" => $tagihan_air + $tagihan_lingkungan + $total_denda
                ]);
            }
            $result->tagihan = array_reverse($result->tagihan);
            $total->total = $total->tagihan_air + $total->tagihan_lingkungan + $total->tagihan_lain + $total->total_denda;

        }
        else if($type == "history"){
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
                        ->from("v_sales_force_history")
                        // ->where("uid","$uid")
                        ->where("unit_id",$resultUnit->unit_id)
                        ->limit(12)
                        ->order_by("periode")
                        ->get()->result();
            foreach ($resultTMP as $key => $v) {
                $total->tagihan_air          += $v->tagihan_air;
                $total->tagihan_lingkungan   += $v->tagihan_lingkungan;
                $total->tagihan_lain         += $v->tagihan_lain;
                $total->total_denda          += $v->total_denda;
                $total->total                += $v->total;
            }
            // $result = $this->db->select("*")->from("v_xendit_history")->where("uid = $uid")->get()->result();
        }else
            $this->response(null,400);

        // echo("<pre>");   
        //     print_r($project);
        // echo("</pre>");
        $result->info = (object)[];
        $result->info->project  = $resultUnit->project;
        $result->info->kawasan  = $resultUnit->kawasan;
        $result->info->blok     = $resultUnit->blok;
        $result->info->no_unit  = $resultUnit->no_unit;
        $result->info->xendit = $resultUnit->xendit;
        $result->info->midtrans = $resultUnit->midtrans;
        
        
        $result->total = $total;
        // $result->tagihan = $resultTMP;
        $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

    }
    public function users_get($id=null)
    {

        // Users from a data store e.g. database
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $id = $id;

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $user = NULL;

        if (!empty($users))
        {
            foreach ($users as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $user = $value;
                }
            }
        }

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
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

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
