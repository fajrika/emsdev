<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        if (!$this->m_login->status_login()) redirect(site_url());
        $this->load->model('transaksi/m_pembayaran');
        $this->load->model('transaksi/m_deposit');

        $this->load->model('m_core');
        ini_set('memory_limit', '256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');
    }

    public function index()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link href="<?= base_url() ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                dir {
                    padding-left: 0;
                }
            </style>
        </head>

        <body>
            <form>
                <textarea id="command" class="col-md-10 col-md-offset-1" name="command" cols="30" rows="10"></textarea>
                <br>
                <div class="col-md-12">
                    <button class="col-md-2 col-md-offset-5">Submit</button>
                </div>
                <div id='hasil' class="col-md-12">

                    <table class="col-md-12 table table-strip">
                        <thead>
                            <tr>
                                <th>Command</th>
                                <th>result</th>
                            </tr>
                        </thead>
                        <tbody id='tbody'>

                        </tbody>
                    </table>
                </div>
            </form>
            <script src="<?= base_url() ?>vendors/jquery/dist/jquery.min.js"></script>
            <script>
                abc = '';
                $("form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        data: {
                            command: $("#command").val()
                        },
                        url: "<?= site_url() ?>/test/ajax_command",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            data = "<tr><td>" + $("#command").val() + "</td><td><pre>" + data + "</pre></td></tr>";
                            console.log(data);
                            // data = data.replace('<dir>','abc');
                            // data = data.replace('</dir>','');
                            // abc = data;
                            data = data + $("#tbody").html();
                            $("#tbody").html(data);
                        }
                    });
                });
            </script>
        </body>

        </html>
<?php
    }
    public function ajax_command()
    {
        print_r(json_encode(shell_exec($this->input->post('command'))));
    }
    public function sf()
    {
        $uid = $this->input->get("uid");
        $resultUnit = $this->db
            ->select("
                unit.id as unit_id,
                kawasan.name as kawasan,
                blok.name as blok,
                project.name as project,
                unit.no_unit,
                xendit_sub_account.sub_account as xendit,
                pt_apikey.apikey as midtrans
                ")
            ->from("unit")
            ->join(
                'pt_apikey',
                'pt_apikey.pt_id = unit.pt_id',
                "LEFT"
            )
            ->join(
                "project",
                "project.id = unit.project_id"
            )
            ->join(
                "blok",
                "blok.id = unit.blok_id"
            )
            ->join(
                "kawasan",
                "kawasan.id = blok.kawasan_id"
            )
            ->join(
                "xendit_sub_account",
                "xendit_sub_account.project_id = unit.project_id
                AND xendit_sub_account.pt_id = unit.pt_id",
                "LEFT"
            )
            ->where("CONCAT(project.source_id,kawasan.code,blok.code,'/',unit.no_unit)", "$uid")
            // ->order_by("")
            ->get()->row();
        echo ('<pre>');
        print_r($resultUnit);
        echo ('</pre>');
        $param = [
            'unit_id' => $resultUnit->unit_id,
            'status_tagihan' => 0,
            'date' => date("Y-m-d")
        ];
        // echo json_encode($param)
        $tagihans = $this->m_tagihan->get_tagihan_gabungan($param);
        echo ('<pre>');
        print_r($tagihans);
        echo ('</pre>');
    }
}
