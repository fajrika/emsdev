<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- select2 -->
<link href="<?= base_url(); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<!-- date time picker -->
<script type="text/javascript" src="<?= base_url(); ?>vendors/moment/min/moment.min.js"></script>
<link href="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- flat -->
<link href="<?= base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<!-- JQUERY MASK -->

<style>
	.invalid {
		background-color: lightpink;
	}

	.has-error {
		border: 1px solid rgb(185, 74, 72) !important;
	}

	.text-right {
		text-align: right;
	}
</style>
<div style="float:right">
	<h2>
		<button class="btn btn-success" onClick="location.reload()">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">

	<br>
	<form id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="post" action="<?= site_url(); ?>/Transaksi/P_transaksi_generate_bill/save" autocomplete="off">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Kawasan - Blok - Unit - Pemilik</label>
				<div class="col-lg-8 col-md-9 col-sm-12 col-xs-12">
					<select name="unit_virtual" required="" id="unit_virtual" class="form-control select2" placeholder="-- Pilih Kawasan - Blok - Unit - Pemilik --">
						<?php if ($unit_virtual->id != 0) : ?>
							<option selected value="<?= $unit_virtual->id ?>"><?= $unit_virtual->text ?></option>
						<?php endif; ?>
					</select>
				</div>
			</div>
		</div>



		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Total Tagihan</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<input id="total_tagihan" type="text" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Cara Pembayaran</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<select name="cara_pembayaran_jenis" required="" id="cara_pembayaran_jenis" class="form-control select2" placeholder="-- Pilih Cara Pembayaran (Code - Name) --">
						<option value="" disabled selected>-- Pilih Cara Pembayaran (Code - Name) --</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Di Kirim Ke Bank</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<select name="cara_pembayaran" required="" id="cara_pembayaran" class="form-control select2" placeholder="-- Pilih Bank --" disabled>
						<option value="" disabled selected>-- Pilih Bank --</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="label_biaya_admin">Biaya Admin</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<input id="view_biaya_admin_pembayaran" type="text" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="label_di_bayar_dengan">Di Bayar dengan<br>-</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<input id="di_bayar_dengan" type="text" class="form-control" readonly>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Tanggal <br>Input</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<input type="date" value="<?= date("Y-m-d") ?>" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Tanggal Pembayaran</label>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<input id="tgl_pembayaran" type="text" value="<?= date("d/m/Y") ?>" class="form-control tgl_pembayaran">
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<br>
		<br>
		<div class="table-responsive">

		</div>
		<div class="col-md-12" id="dataisi">
			<div class="card-box table-responsive">
			</div>
			<div id="div_table" class="col-md-12 card-box table-responsive">
				<table id="table-tagihan" class="table table-striped table-bordered " style="width:100%">
					<thead>
						<tr>
							<th class="col-md-1 col-sm-1 col-lg-1 col-xs-1" id="di_bayar_dengan_table">
								<input id="check-all-bayar" type='checkbox' class='flat table-check'> Bayar
							</th>
							<th class='text-right'>Periode Penggunaan</th>
							<th>Service</th>
							<th class='text-right'>Nilai Pokok</th>
							<th class='text-right'>Denda</th>
							<th class='text-right'>Pinalty</th>
							<th class='text-right'>Tunggakan</th>
							<th class='text-right'>Total</th>
							<th class='text-right col-lg-1 col-md-1'>Dibayar</th>
						</tr>
					</thead>
					<tbody id="tbody-tagihan">
							<tr>
								<td> 
									<input type="checkbox" name="" id="">
								</td>
								<td>
									2020-06-01
								</td>
								<td>
									100.000
								</td>
								<td>
									5.000
								</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>105.000</td>
							</tr>
							
							<td> 
									<input type="checkbox" name="" id="">
								</td>
								<td>
									2020-07-01
								</td>
								<td>
									100.000
								</td>
								<td>
									5.000
								</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
								<td>105.000</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="form-group" style="margin-top:20px">
				<div class="center-margin">
					<button class="btn btn-primary" type="reset">Reset</button>
					<a data-toggle="modal" id="button-submit" class="btn btn-success">Submit</a>
				</div>
			</div>
		</div>
	</form>
	<div class="x_content">
		<div class="modal fade modal-move" id="modal-save" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width:35%;margin:auto">
				<div class="modal-content" style="margin-top:100px;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" style="text-align:center;">Pembayaran<span class="grt"></span></h4>
					</div>
					<div class="modal-body">
						<div class="form-horizontal ">

							<!-- Apakah anda yakin untuk menyimpan data deposit<br>
							( Note : Pastikan anda telah benar-benar menerima uang deposit ) -->
							<div class="clearfix"></div>
							<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
								<label>
									Rincian <span id="label-diskon">(Diskon - Pegawai - Rumah)</span>
								</label>
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<td>Service</td>
											<td>Tagihan yang dibayar* (Bulan)</td>
											<td>Tagihan yang dibayar* (Rp.)</td>
											<td>Nilai Diskon Awal</td>
											<td>Nilai Diskon (Rp.)</td>
										</tr>
									</thead>
									<tbody id="tbody-diskon">

									</tbody>
								</table>
								<br>* Tidak termasuk Tunggakan
							</div> -->
							<div class="col-md-offset-3 col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-top:20px">
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="">Total Bayar</label>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										Rp.
									</div>
									<div class="col-lg-8 col-md-8 col-sm-11 col-xs-11">
										<input id="total-bayar" type="text" class="form-control" val=0 readonly style="text-align: right;">
									</div>
								</div>
							</div>
							<div class="col-md-offset-3 col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-top:20px">
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="modal_label_biaya_admin">Biaya Admin <br> - </label>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										Rp.
									</div>
									<div class="col-lg-8 col-md-8 col-sm-1 col-xs-11">
										<input id="biaya_admin_pembayaran" type="text" class="form-control" readonly style="text-align: right;">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="modal_label_biaya_admin">Total Diskon </label>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										Rp.
									</div>
									<div class="col-lg-8 col-md-8 col-sm-1 col-xs-11">
										<input id="total_diskon" type="text" class="form-control" readonly style="text-align: right;">
									</div>
								</div>
								<!-- <div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Biaya Admin (Metode Penagihan)</label>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										<inputtype="text" class="form-control" val="Rp." readonly style="text-align: left;">
									</div>
									<div class="col-lg-8 col-md-8 col-sm-1 col-xs-11">
										<input id="biaya_admin_penagihan" type="text" class="form-control" readonly style="text-align: right;">
									</div>
								</div> -->

							</div>
							<div class="col-md-offset-3 col-lg-9 col-md-9 col-sm-12 col-xs-12">

								<div class="form-group">
									<label class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12" id="modal_label_di_bayar_dengan">Di Bayar dengan<br>-</label>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
										Rp.
									</div>
									<div class="col-lg-8 col-md-8 col-sm-1 col-xs-11">
										<input id="modal_di_bayar_dengan" type="text" class="form-control" readonly style="text-align: right;">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
						<button type="button" class="btn btn-primary" data-dismiss="modal" id="delete_cancel_link">Close</button>
						<button type="button" class="btn btn-success" data-dismiss="modal" id="button-modal-submit">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="x_content">
		<div class="modal fade" id="modal_cetak_kwitansi" data-backdrop="static" data-keyboard="false" style="width:100vw">
			<div class="modal-dialog">
				<div class="modal-content" style="margin-top:100px; width:fit-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" style="text-align:center;">Service<span class="grt"></span></h4>
					</div>
					<div class="modal-body">
						<table id="table-kwitansi" class="table table-striped jambo_table">
							<thead>
								<tr>
									<th>Check</th>
									<th>Kode Service</th>
									<th>Nama Service</th>
									<th>Tgl Bayar</th>
									<th>Cetak</th>
									<th class='input_kwitansi'>No. Kwitansi</th>
									<th class='input_kwitansi'>Save</th>
								</tr>
							</thead>
							<tbody id="tbody-kwitansi">
							</tbody>
						</table>
					</div>

					<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
						<button id="cetak-kwitansi-multiple" class="btn btn-primary">Cetak Multiple</button>
						<button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		var table_tagihan = $("#table-tagihan").DataTable({
								"lengthChange": false,
								"paging":   false,
								"info":     false
							});

		$("#cara_pembayaran_jenis").select2({
			width: 'resolve',
			minimumInputLength: 0,
			placeholder: "Cara Pembayaran Jenis",
			ajax: {
				type: "GET",
				dataType: "json",
				data: $(this).val(),
				url: "<?= site_url() ?>/Transaksi/P_pembayaran/ajax_get_cara_pembayaran_jenis/",
				data: function(params) {
					console.log(params);
					return {
						data: params.term
					}
				},
				processResults: function(data) {
					return {
						results: data
					};
				}
			}
		}).change(function() {
			$.ajax({
				type: "GET",
				url: "<?= site_url() ?>/Transaksi/P_pembayaran/ajax_get_cara_pembayaran_bank/" + $(this).val(),
				dataType: "json",
				success: function(data) {
					$("#cara_pembayaran").attr('disabled', false);
					$("#cara_pembayaran").html("<option value='" + data[0].id +"' selected>"+ data[0].text+"</option>")
				}
			});
			$("#cara_pembayaran").select2({
				width: 'resolve',
				minimumInputLength: 0,
				placeholder: "Cara Pembayaran Jenis",
				ajax: {
					type: "GET",
					dataType: "json",
					data: $(this).val(),
					url: "<?= site_url() ?>/Transaksi/P_pembayaran/ajax_get_cara_pembayaran_bank/" + $(this).val(),
					data: function(params) {
						console.log(params);
						return {
							data: params.term
						}
					},
					processResults: function(data) {
						return {
							results: data
						};
					}
				}
			})
		});



		$("#unit_virtual").select2({
			width: 'resolve',
			// resize:true,
			minimumInputLength: 0,
			placeholder: 'Kawasan - Blok - Unit - Pemilik',
			ajax: {
				type: "GET",
				dataType: "json",
				data: $(this).val(),
				url: "<?= site_url() ?>/Transaksi/P_pembayaran/ajax_get_unit_virtual/",
				data: function(params) {
					return {
						data: params.term
					}
				},
				processResults: function(data) {
					console.log(data);
					return {
						results: data
					};
				}
			}
		}).change(function(){
			table_tagihan.rows().remove().draw();
			$.ajax({
				type: "POST",
				data: {
					unit_virtual_id: $("#unit_virtual").val(),
					date: $("#tgl_pembayaran").val()

				},
				url: "<?= site_url() ?>/Transaksi/P_pembayaran/ajax_get_tagihan_unit_virtual",
				dataType: "json",
				success: function(data) {
					console.log(data);
					table_tagihan.rows().remove().draw();
					data.tagihan_layanan_lain.forEach(e => {
						
					});
					table_tagihan.rows.add().draw()
				}
			});
		});




	});
</script>