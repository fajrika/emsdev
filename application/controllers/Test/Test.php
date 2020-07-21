<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function index()
	{
		$this->load->model('m_core');

		$this->load->model('Transaksi/m_pemutihan');
		$kawasan = 211;
		$blok = 1880;
		$periode_awal = "01/2019";
		$periode_akhir = "01/2019";
		$metode_tagihan = [1];

		echo json_encode($this->m_pemutihan->get_unit_test($blok, $kawasan, $periode_awal, $periode_akhir, $metode_tagihan));
	}
	public function get_gabungan()
	{
		$this->load->model('m_core');

		$this->load->model('core/m_tagihan');
		// $periode_awal = "01/2020";
		// $periode_akhir = "12/2020";
		$metode_tagihan = [1, 2];
		$param = (object)[];

		// $periode_awal = substr($periode_awal, 3, 4) . "-" . substr($periode_awal, 0, 2) . "-01";
		// $periode_akhir = substr($periode_akhir, 3, 4) . "-" . substr($periode_akhir, 0, 2) . "-01";
		$param->status_tagihan = [0, 4];
		// $param->kawasan_id = 220;
		$param->unit_id = 255826;
		// $param->blok_id = $blok;
		// $param->project_id = 13;
		$param->service_jenis_id = $metode_tagihan;
		// $param->periode_awal = $periode_awal;
		// $param->periode_akhir = $periode_akhir;
		$param->date = date("Y-m-d");

		$tagihans = $this->m_tagihan->get_tagihan_gabungan($param);
		echo json_encode($tagihans);
	}
	public function get_lingkungan()
	{
		$this->load->model('m_core');

		$this->load->model('core/m_tagihan');
		$kawasan = 211;
		$blok = 1880;
		$periode_awal = "01/2019";
		$periode_akhir = "12/2019";
		$metode_tagihan = [1];
		$param = (object)[];

		$periode_awal = substr($periode_awal, 3, 4) . "-" . substr($periode_awal, 0, 2) . "-01";
		$periode_akhir = substr($periode_akhir, 3, 4) . "-" . substr($periode_akhir, 0, 2) . "-01";
		$param->status_tagihan = [0];
		$param->kawasan_id = $kawasan;
		$param->blok_id = $blok;
		$param->service_jenis_id = $metode_tagihan;
		$param->periode_awal = $periode_awal;
		$param->periode_akhir = $periode_akhir;
		$param->date = date("Y-m-d");
		$tagihans = $this->m_tagihan->get_lingkungan($param);

		echo json_encode($tagihans);
		// echo $this->db->last_query;
	}
	public function get_air()
	{
		$this->load->model('m_core');

		$this->load->model('core/m_tagihan');
		$kawasan = 211;
		$blok = 1880;
		$periode_awal = "01/2019";
		$periode_akhir = "12/2019";
		$metode_tagihan = [1];
		$param = (object)[];

		$periode_awal = substr($periode_awal, 3, 4) . "-" . substr($periode_awal, 0, 2) . "-01";
		$periode_akhir = substr($periode_akhir, 3, 4) . "-" . substr($periode_akhir, 0, 2) . "-01";
		$param->status_tagihan = [0];
		$param->kawasan_id = $kawasan;
		$param->blok_id = $blok;
		$param->service_jenis_id = $metode_tagihan;
		$param->periode_awal = $periode_awal;
		$param->periode_akhir = $periode_akhir;

		$tagihans = $this->m_tagihan->get_air($param, date("Y-m-d"));

		echo json_encode($tagihans);
	}
	public function get_sf()
	{
		$uid = "2076MV-CAB.10/32";
		$this->load->model('core/m_tagihan');

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
		$param = [
			'unit_id' => $resultUnit->unit_id,
			'status_tagihan' => 0,
			'date' => date("Y-m-d")
		];
		// echo json_encode($param)
		$tagihans = $this->m_tagihan->get_air($param);
		echo json_encode($tagihans);
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
		die;
		$param = [
			'unit_id' => $resultUnit->unit_id,
			'status_tagihan' => 0,
			'date' => date("Y-m-d")
		];
		// echo json_encode($param)
		$this->load->model("core/m_tagihan");

		$tagihans = $this->m_tagihan->get_tagihan_gabungan($param);
		echo ('<pre>');
		print_r($tagihans);
		echo ('</pre>');
	}
	public function mpdf()
	{
		require_once 'vendor/MPDF/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
		$row = $this->db
					->from('template_pdf')
					->where('id',1)
					->get()->row();
		$row = $row->tema;

		$mpdf->WriteHTML("<link href='//cdn.quilljs.com/1.0.0/quill.snow.css' rel='stylesheet'>");
		$mpdf->WriteHTML($row);
		$mpdf->WriteHTML("abc");
		$mpdf->Output();
		// $mpdf->OverWrite('pdf/template.pdf', [], [], 'I', 'mpdf.pdf');
		// $mpdf->WriteHTML('Hello World');
		// $mpdf->Output();
	}
}
