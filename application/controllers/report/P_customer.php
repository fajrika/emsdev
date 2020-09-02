<?php
defined('BASEPATH') or exit('No direct script access allowed');
class P_customer extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('m_core');
		global $jabatan;
		$jabatan = $this->m_core->jabatan();
		global $project;
		$project = $this->m_core->project();
		global $menu;
		$menu = $this->m_core->menu();
		global $unit_id;
		$unit_id = $this->m_core->unit_id();
		ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
    }

    public function index()
    {
        $kawasan = $this->db->select("id, code, name")->from("kawasan")->where("project_id", $GLOBALS['project']->id)->order_by('id ASC')->get()->result();

		$this->load->view('core/header');
		$this->load->view('core/side_bar',['menu' => $GLOBALS['menu']]);
		$this->load->view('core/top_bar',['jabatan' => $GLOBALS['jabatan'],'project' => $GLOBALS['project']]);
		$this->load->view('core/body_header',['title' => 'Report Customer', 'subTitle' => 'List']);
		$this->load->view('proyek/report/rpt_customer/view', ['kawasan'=>$kawasan]);
		$this->load->view('core/body_footer');
		$this->load->view('core/footer');
    }


    public function request_cust_json()
    {
        // ini_set('memory_limit', '1024M'); // or you could use 1G
        $requestData    = $_REQUEST;
        $like_value     = $requestData['search']['value'];
        $column_order   = $requestData['order'][0]['column'];
        $column_dir     = $requestData['order'][0]['dir'];
        $limit_start    = $requestData['start'];
        $limit_length   = $requestData['length'];
        $id_kawasan     = $this->input->post('id_kawasan');
        $blok           = $this->input->post('id_blok');
        $where_blok     = '';
        if ($blok !== 'all') {
            $where_blok = "AND dbo.blok.id  = '".$blok."'";
        }

        $sql = " 
            SELECT 
                ROW_NUMBER() OVER (ORDER BY dbo.unit.id) AS nomor,
                dbo.unit.id AS id_unit,
                dbo.project.id AS project_id,
                dbo.project.name AS project,
                dbo.kawasan.id AS id_kawasan,
                dbo.kawasan.name AS kawasan,
                dbo.blok.id AS id_blok,
                dbo.blok.name AS blok,
                dbo.unit.no_unit,
                pemilik.name AS pemilik,
                pemilik.ktp AS NIK_pemilik,
                pemilik.address,
                pemilik.mobilephone1,
                pemilik.mobilephone2,
                pemilik.homephone,
                pemilik.officephone,
                pemilik.email,
                pemilik.npwp_no AS NPWP,
                dbo.unit.tgl_st AS [Tanggal Serah Terima],
                pemilik.description,
                dbo.unit.virtual_account 
            FROM
                dbo.unit
                INNER JOIN dbo.project ON dbo.project.id = dbo.unit.project_id
                INNER JOIN dbo.blok ON dbo.blok.id = dbo.unit.blok_id
                INNER JOIN dbo.kawasan ON dbo.kawasan.id = dbo.blok.kawasan_id
                INNER JOIN dbo.customer AS pemilik ON pemilik.id = dbo.unit.pemilik_customer_id
                INNER JOIN dbo.customer AS penghuni ON penghuni.id = dbo.unit.penghuni_customer_id
            WHERE 1=1
                AND dbo.kawasan.id = '".$id_kawasan."'
                $where_blok 
                AND (
                    dbo.kawasan.name LIKE '%".$this->db->escape_like_str($like_value)."%'
                    OR dbo.blok.name LIKE '%".$this->db->escape_like_str($like_value)."%'
                    OR dbo.unit.no_unit LIKE '%".$this->db->escape_like_str($like_value)."%'
                    OR pemilik.name LIKE '%".$this->db->escape_like_str($like_value)."%'
                )
            ";
        // print_r($sql);
        $data_sql['totalFiltered']  = $this->db->query($sql)->num_rows();
        $data_sql['totalData']      = $this->db->query($sql)->num_rows();
        $columns_order_by = array(
            0 => 'nomor',
            1 => 'dbo.kawasan.name',
            2 => 'dbo.blok.name',
            3 => 'dbo.unit.no_unit',
            4 => 'pemilik.name',
            5 => 'pemilik.mobilephone1'
        );

        $sql  .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir." ";
        $sql  .= " OFFSET ".$limit_start." ROWS FETCH NEXT ".$limit_length." ROWS ONLY ";

        $data_sql['query'] = $this->db->query($sql);
        $totalData       = $data_sql['totalData'];
        $totalFiltered   = $data_sql['totalFiltered'];
        $query           = $data_sql['query'];

        $data   = array();
        $urut1  = 1;
        $urut2  = 0;
        foreach($query->result_array() as $row)
        {
            $nestedData  = array();
            $total_data  = $totalData;
            $start_dari  = $requestData['start'];
            $perhalaman  = $requestData['length'];
            $asc_desc    = $requestData['order'][0]['dir'];
            if($asc_desc == 'asc'){
                $nomor = $urut1 + $start_dari;
            }
            if($asc_desc == 'desc'){
                $nomor = ($total_data - $start_dari) - $urut2;
            }

            $nestedData[] = $nomor;
            $nestedData[] = $row['kawasan'];
            $nestedData[] = $row['blok'];
            $nestedData[] = $row['no_unit'];
            $nestedData[] = strtoupper($row['pemilik']);
            $nestedData[] = $row['mobilephone1'];
            $data[] = $nestedData;
            $urut1++;
            $urut2++;
        }

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );
        echo json_encode($json_data);
    }

    public function ajax_get_blok()
    {
        $id      = $this->input->get('id');
        $project = $this->m_core->project();
        $result  = $this->db
            ->select("blok.id, blok.code, blok.name")
            ->from("blok")
            ->join("kawasan", "kawasan.id = blok.kawasan_id")
            ->where("kawasan.project_id", $project->id);

        if ($id !== 'all')
        {
            $result = $result->where("kawasan.id", $id);
        }
        $result = $result->get()->result();
		echo json_encode($result);
	}
	// public function ajax_get_unit(){
	// 	echo json_encode($this->m_aging->ajax_get_unit($this->input->get('kawasan'),$this->input->get('blok'),$this->input->get('periode')));
	// }
	// public function ajax_get_aging(){
	// 	$kawasan_id = $this->input->get('kawasan');
	// 	$blok_id = $this->input->get('blok');
	// 	$tgl_aging = $this->input->get('tgl_aging');
	// 	$tgl_aging = substr($tgl_aging,6,4)."-".substr($tgl_aging,3,2)."-".substr($tgl_aging,0,2);
	// 	// var_dump($tgl_aging);
	// 	$result = $this->m_aging->ajax_get_aging($kawasan_id,$blok_id,$tgl_aging);
	// 	echo json_encode($result);
	// }
}
?>