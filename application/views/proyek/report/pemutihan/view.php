<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<link rel="stylesheet" href="<?=base_url(); ?>vendors/select2/dist/css/select2.min.css">
<script src="<?=base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.history.back()" disabled>
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
	<table id="tableDT2" class="table table-striped jambo_table bulk_action">
		<tfoot id="tfoot" style="display: table-header-group">
			<tr>
				<th>No</th>
				<th>Kode Pemutihan</th>
				<th>Masa Awal</th>
				<th>Masa Akhir</th>
				<th>Perkiraan Total (Rp.)</th>
				<th>Status</th>				
				<th>Detail</th>				
			</tr>
		</tfoot>
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Pemutihan</th>
				<th>Masa Awal</th>
				<th>Masa Akhir</th>
				<th>Perkiraan Total (Rp.)</th>
				<th>Status</th>
				<th>Detail</th>				
			</tr>
		</thead>
		<tbody>
			<?php
            $i = 0;
            foreach ($data as $key => $v) {
                ++$i;
                echo '<tr>';
					echo "<td>$i</td>";
					echo "<td>$v->code</td>";
					echo "<td>$v->masa_awal</td>";
					echo "<td>$v->masa_akhir</td>";
					echo "<td class='text-right'>".number_format($v->perkiraan_total)."</td>";
					echo "<td>$v->status</td>";
					echo "<td><button id='redirect-pembayaran' onclick='modal_large($v->id)' class='btn btn-primary col-md-10' style='margin-left:4.1%'>Detail</button></td>";                
					// echo "<td><a class='btn btn-primary' href='".site_url("report/P_pemutihan/edit/$v->id")."'>Detail</a></td>";
                echo '</tr>';
            }
            ?>
		</tbody>
		
	</table>
	<div class="x_content">
		<div class="modal fade" id="modal-large" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" style="width: 100%">
				<div class="modal-content">

					<div class="modal-header" style="height: 45px">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modal_close()">&times;</button>
						<h4 id="modal-title-large" class="modal-title" style="text-align:center;">Pemutihan Detail<span class="grt"></span></h4>
					</div>
					<div class="modal-body" style="height: 80%">
						<div id="large-modal-body">
							<table id="tableModal" class="table table-striped jambo_table bulk_action">
								<tfoot id="tfoot" style="display: table-header-group">
									<tr>
										<th>Kawasan</th>
										<th>Blok</th>
										<th>No Unit</th>
										<th>Pemilik</th>
										<th>Service</th>
										<th>Periode</th>
										<th>Nilai Pemutihan Tagihan</th>				
										<th>Nilai Pemutihan Denda</th>				
										<th>Nilai Pemutihan Total</th>				
									</tr>
								</tfoot>
								<thead>
									<tr>
										<th>Kawasan</th>
										<th>Blok</th>
										<th>No Unit</th>
										<th>Pemilik</th>
										<th>Service</th>
										<th>Periode</th>
										<th>Nilai Pemutihan Tagihan</th>
										<th>Nilai Pemutihan Denda</th>				
										<th>Nilai Pemutihan Total</th>				
									</tr>
								</thead>
								<tbody id="tbody-modal">

								</tbody>
								
							</table>
						</div>
					</div>

					<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center; height:65px">
						<button id="modal-large-newtab" type="button" class="btn btn-primary" disabled>Open New Tab</button>

						<button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link" onclick="modal_large_close()">Close</button>

					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

		$(document).ready(function () {
			$("#a").html('');
			$('.select2').select2();

		});
		
		function modal_large(id) {

			$("#modal-large").modal("show");
			$.ajax({
                type: "GET",
                url: "<?= site_url() ?>/report/P_pemutihan/ajax_get_detail/"+id,
                dataType: "json",
                success: function(data) {
                    console.log(data);
					var table2 = $('#tableModal').DataTable();
					table2.destroy();
					
                    $("#tbody-modal").html("");
					$.each(data, function(key, value) {
						var str = "<tr>";
						str += "<td>" + value.kawasan + "</td>";
						str += "<td>" + value.blok + "</td>";
						str += "<td>" + value.no_unit + "</td>";
						str += "<td>" + value.customer + "</td>";
						str += "<td>" + value.service + "</td>";
						str += "<td>" + value.periode + "</td>";
						str += "<td>" + value.pemutihan_nilai_tagihan + "</td>";
						str += "<td>" + value.pemutihan_nilai_denda + "</td>";
						str += "<td>" + (value.pemutihan_nilai_tagihan+value.pemutihan_nilai_denda) + "</td>";
						str += "</tr>"
						$("#tbody-modal").append(str);
						
					});
					var table2 = $('#tableModal').DataTable();
		
					// Apply the search
					table2.columns().every( function () {
						var that = this;
						$( 'input', this.footer() ).on( 'keyup change', function () {
							if ( that.search() !== this.value ) {
								that
									.search( this.value )
									.draw();
							}
						} );
					} );
                }
            });
		}
		$(document).ready(function() {

			// Setup - add a text input to each footer cell
			$('#tableDT2 tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			} );
		
			// DataTable
			var table = $('#tableDT2').DataTable();
		
			// Apply the search
			table.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			} );
			
			// Setup - add a text input to each footer cell
			$('#tableModal tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			} );
		
			// DataTable
			
			
		} );
	</script>