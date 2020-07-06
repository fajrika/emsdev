<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?=base_url(); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?=base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<!DOCTYPE html>
<link href="<?=base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?=base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>

<div style="float:right">
	<h2>
        <button class="btn btn-warning" onClick="window.location.href='<?=site_url(); ?>/P_master_tvi_isp'">
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
	<form id="form" class="form-horizontal form-label-left" method="post" action="<?= site_url(); ?>/P_master_tvi_isp/update?id=<?=$this->input->get('id')?>">
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama ISP <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?=$data->name?>">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pembagian_hasil">Pembagian Hasil (%) <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12 row">
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_hasil_1">Ciputra</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_hasil_1" name="pembagian_hasil_1" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value="<?=$data->pembagian_hasil_1?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_hasil_2">ISP</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_hasil_2" name="pembagian_hasil_2" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value="<?=$data->pembagian_hasil_2?>" readonly>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pembagian_pasang_baru">Pembagian Pasang Baru (%) <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12 row">
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_pasang_baru_1">Ciputra</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_pasang_baru_1" name="pembagian_pasang_baru_1" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value="<?=$data->pembagian_pasang_baru_1?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_pasang_baru_2">ISP</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_pasang_baru_2" name="pembagian_pasang_baru_2" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value="<?=$data->pembagian_pasang_baru_2?>" readonly>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea id="description" class="form-control col-md-7 col-xs-12" type="text" name="description"><?=$data->description?></textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="center-margin">
				<button id="btn-cancel" class="btn btn-primary" type="reset">Cancel</button>
				<button id="btn-update" type="submit" class="btn btn-success">Update</button>
				<button id="btn-edit" type="button" class="btn btn-success">Edit</button>
			</div>
		</div>
	</form>

</div>
</div>

<!-- jQuery -->
<script type="text/javascript">
	$(function () {
        $("#btn-cancel").hide();
        $("#btn-update").hide();

        $("#btn-edit").click(function(){
            $("#btn-cancel").show();
            $("#btn-update").show();
            $("#btn-edit").hide();
            $(".form-control").attr('readonly',false);
            $("#pembagian_hasil_2").attr('readonly',true);
            $("#pembagian_pasang_baru_2").attr('readonly',true);
        });
        $("#btn-cancel").click(function(){
            $("#btn-cancel").hide();
            $("#btn-update").hide();
            $("#btn-edit").show();
            $(".form-control").attr('readonly',true);
        });
        $(".form-control").attr('readonly',true);
	});

</script>
