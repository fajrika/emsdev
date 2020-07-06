<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>

<!-- select2 -->
<link href="<?= base_url(); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.location.href='<?= site_url(); ?>/P_master_tvi_paket'">
			<i class="fa fa-arrow-left"></i>
			Back
		</button>
		<button class="btn btn-success" onClick="window.location.reload()">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
	<br>
	<form id="form" class="form-horizontal form-label-left" method="post" action="<?= site_url(); ?>/P_master_tvi_paket/save">
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ISP<span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<select class="form-control col-md-7 col-xs-12" name="isp_id" id="isp_id" require>
					<option disabled selected>Pilih ISP</option>
					<?php foreach ($datas as $i => $data):?>
						<option value="<?=$data->id?>"><?=$data->name?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Paket <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Harga Paket <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="number" id="harga" name="harga" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Harga Pasang Baru <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="harga_pasang_baru" name="harga_pasang_baru" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pembagian_hasil">Durasi <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12 row">
				<div class="form-group col-md-6">
					<input type="number" id="durasi" name="durasi" required="required" class="form-control col-md-12 col-xs-12" min=0>
				</div>
				<div class="form-group col-md-6">
					<select name="tipe_durasi" id="tipe_durasi" class="form-control col-md-12 col-xs-12">
						<option disabled selected>Pilih Tipe Durasi</option>
						<option value="1">Hari</option>
						<option value="2">Bulan</option>
						<option value="3">Tahun</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bandwidth KB/S<span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="bandwidth" name="bandwidth" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea id="description" class="form-control col-md-7 col-xs-12" type="text" name="description"></textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="center-margin">
				<button class="btn btn-primary" type="reset">Reset</button>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
	</form>

</div>


<!-- jQuery -->
<script type="text/javascript">
	$(function() {
		$("#isp_id").select2();
		$("#tipe_durasi").select2();
	});
</script>