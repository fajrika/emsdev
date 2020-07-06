<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.location.href='<?= site_url(); ?>/P_master_tvi_isp'">
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
	<form id="form" class="form-horizontal form-label-left" method="post" action="<?= site_url(); ?>/P_master_tvi_isp/save">
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama ISP <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
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
						<input type="number" id="pembagian_hasil_1" name="pembagian_hasil_1" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value=50>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_hasil_2">ISP</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_hasil_2" name="pembagian_hasil_2" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value=50 readonly>
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
						<input type="number" id="pembagian_pasang_baru_1" name="pembagian_pasang_baru_1" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value=50>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pembagian_pasang_baru_2">ISP</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="number" id="pembagian_pasang_baru_2" name="pembagian_pasang_baru_2" required="required" class="form-control col-md-7 col-xs-12" min=0 max=100 value=50 readonly>
					</div>
				</div>
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
			$("#pembagian_hasil_1").keyup(function(){
				$("#pembagian_hasil_1").val(parseInt($("#pembagian_hasil_1").val()));
				if($("#pembagian_hasil_1").val() < 0 || !$("#pembagian_hasil_1").val()){
					$("#pembagian_hasil_1").val(0);
					$("#pembagian_hasil_2").val(100);
					
				}else if($("#pembagian_hasil_1").val() > 100){
					$("#pembagian_hasil_1").val(100);
					$("#pembagian_hasil_2").val(0);
				}else{
					$("#pembagian_hasil_2").val(100 - $("#pembagian_hasil_1").val());
				}
			})
			$("#pembagian_pasang_baru_1").keyup(function(){
				$("#pembagian_pasang_baru_1").val(parseInt($("#pembagian_pasang_baru_1").val()));
				if($("#pembagian_pasang_baru_1").val() < 0 || !$("#pembagian_pasang_baru_1").val()){
					$("#pembagian_pasang_baru_1").val(0);
					$("#pembagian_pasang_baru_2").val(100);
					
				}else if($("#pembagian_pasang_baru_1").val() > 100){
					$("#pembagian_pasang_baru_1").val(100);
					$("#pembagian_pasang_baru_2").val(0);
				}else{
					$("#pembagian_pasang_baru_2").val(100 - $("#pembagian_pasang_baru_1").val());
				}
			})
		});
</script>