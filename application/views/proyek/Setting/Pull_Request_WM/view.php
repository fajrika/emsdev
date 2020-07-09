<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<link rel="stylesheet" href="<?=base_url(); ?>vendors/select2/dist/css/select2.min.css">
<script src="<?=base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.history.back()">
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


<div class="x_content">
	<div class="modal fade" id="modal_delete_m_n" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" style="margin-top:100px;">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="text-align:center;">Apakah anda yakin untuk mendelete data ini ?<span class="grt"></span> ?</h4>
				</div>

				<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
					<span id="preloader-delete"></span>
					<br>
					<a class="btn btn-danger" id="delete_link_m_n" href="">Delete</a>
					<button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Cancel</button>

				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
            $("#loading").show();
            
            setInterval(function(){ 
                $("#loading").hide();
            }, 3000);

            $.ajax({
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "kvo5SGch0NE8OxiX3Qg9wPfug6Gyk4WtPjvxaiPxUMEmRUNRqEQkMsrUjLWF");
                },
                type: "GET",
                data: {
                    id: "<?=$project_id?>",
                    module: "project"
                },
                url: "https://watermeter-api-ces-ems.ciputragroup.com:11443/pull-request",
                dataType: "application/json",
                success: function(data) {
                    console.log(data);
                    setInterval(function(){ 
                        $("#loading").hide();
                    }, 3000);
                }
            });
		});
	</script>