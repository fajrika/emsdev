<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- select2 -->
<link href="<?= base_url(); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<!-- switchery -->
<link href="<?= base_url() ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- flat -->
<link href="<?= base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
<!-- date time picker -->
<script type="text/javascript" src="<?= base_url(); ?>vendors/moment/min/moment.min.js"></script>
<link href="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<div style="float:right">
    <h2>
        <button class="btn btn-warning" onClick="window.location.href='<?= site_url() . '/' . $this->uri->segment(1) ?>'">
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.href='<?= site_url() . '/' . $this->uri->segment(1) ?>/add'">
            <i class="fa fa-repeat"></i>
            Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
<?php 
    $fullUrl = site_url()."/".implode("/",(array_slice($this->uri->segment_array(),0,-1)));
?>
<div class="x_content">
    <br>


    <form action="<?=site_url('Sync/Desktop_meter_air/proses')?>" method="get">
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
            <div class="form-group">
                <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Nama File</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <input id="nameFile" type="text" class="form-control" name="nameFile">
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
			<div class="form-group">
            <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Periode Tagihan</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
					<div class='input-group date datetimepicker_month'>
						<input id="periode" type="text" class="form-control datetimepicker_month" name="periode" placeholder="periode">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
            <div class="form-group">
                <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Unit <br>(ex. OW03/010)</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <select class="form-control select2_unit" name="unit" id="unit">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
            <div class="form-group">
                <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Meter Awal</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <select class="form-control select2_meter_awal" name="meter_awal" id="meter_awal">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
            <div class="form-group">
                <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Meter Akhir</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <select class="form-control select2_meter_akhir" name="meter_akhir" id="meter_akhir">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:20px">
            <div class="form-group">
                <label class="control-label col-lg-1 col-md-1 col-sm-12 col-md-offset-3">Ke Project</label>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <select id="project_id" type="text" class="select2 form-control" name="project_id" placeholder="Project">
                        <?php foreach ($project as $v):?>
                        <option value="<?=$v->id?>"><?=$v->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group" style="margin-top:20px">
                <div class="center-margin">
                    <!-- <button class="btn btn-primary" type="reset" style="margin-left: 110px">Reset</button> -->
                    <!-- <a id="get_data" class="btn btn-success">Get Data</a> -->
                    <button class="btn btn-success" type="submit">Get Data (Submit)</button>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <br>
        <div class="table-responsive">  

        </div>
    </form>
    <br>
</div>

<!-- jQuery -->
<script type="text/javascript" src="<?= base_url(); ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $('.datetimepicker_month').datetimepicker({
        viewMode: 'years',
        format: 'MM/YYYY'
    });
    $("#nameFile").keyup(function() {
        $.ajax({
            type: "GET",
            data: {
                nameFile: $("#nameFile").val()
            },
            url: "<?= site_url('Sync/Desktop_meter_air/get_header') ?>",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $("#unit").html("");
                $("#meter_awal").html("");
                $("#meter_akhir").html("");
                
                $.each(data, function(k, v) {
                    $("#unit").append("<option value='"+ k +"'>"+ v + "</option>");
                    $("#meter_awal").append("<option value='"+ k +"'>"+ v + "</option>");
                    $("#meter_akhir").append("<option value='"+ k +"'>"+ v + "</option>");
                });
            }
        });
    });
    
</script> 