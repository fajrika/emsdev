<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="float:right">
    <h2>
        <!-- <button class="btn btn-primary" onClick="window.location.href='<?= site_url(); ?>/transaksi_lain/p_tvi_aktifasi/add'">
            <i class="fa fa-plus"></i>
            Tambah
        </button> -->
        <button class="btn btn-warning" onClick="window.history.back()" disabled>
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/p_tvi_aktifasi'">
            <i class="fa fa-repeat"></i>
            Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table class="table table-striped jambo_table bulk_action tableDT">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Pemilik</th>
                            <th>ISP</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <!-- <th>Status monitoring</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($monitorings as $i => $monitoring): ?>
                        <tr>
                            <td><?=++$i?></td>
                            <td><?=$monitoring->unit?></td>
                            <td><?=$monitoring->customer_name?></td>
                            <td><?=$monitoring->isp_name?></td>
                            <td><?=$monitoring->paket_name?></td>
                            <td><?=$monitoring->status_aktifasi==0?"Non Aktif":"Aktif"?></td>
                            <td class='col-md-1'>
                                <button 
                                    type="button" 
                                    class="btn btn-primary col-md-12"
                                    onclick="detail_model(<?=$monitoring->id?>)"
                                >
                                    Monitoring (Detail)
                                </button>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>



<!-- (Normal Modal)-->
<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Berikut Detail nya</h4>
            </div>
            
            <div class="modal-body">
                <table class="tableDT3 table table-striped jambo_table">
                    <thead>
                        <tr>
                            <th>Aktifitas</th>
                            <th>Tanggal/Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_monitoring">
                    </tbody>
                </table>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <span id="preloader-delete"></span>
                </br>
                <!-- <a class="btn btn-success" id="action" href="">Aktif</a> -->
                <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Cancel</button>

            </div>
        </div>
    </div>
</div>
<script>
    function detail_model(id) {
        jQuery('#modal_detail').modal('show', {
            backdrop: 'static',
            keyboard: false
        });
        $("#tbody_monitoring").html("");
        $.ajax({
            type: "POST",
            data: {
                id: id            
            },
            url: "<?= site_url() ?>/Transaksi_lain/P_tvi_monitoring/ajax_get_detail",
            dataType: "json",
            success: function(data) {
                $.each(data, function(key, value) {
                    var str = "<tr>";
                    str += "<td>" + value.aktifitas + "</td>";
                    str += "<td>" + value.tanggal + "</td>";
                    str += "<td>" + value.keterangan + "</td>";
                    str += "</tr>"
                    $("#tbody_monitoring").append(str);
                });
            }
        });
        if(status == 1){
            // $("#action").html("Non Aktif");
            // $("#action").attr("class","btn btn-danger");
            // $("#action").attr("href","<?= site_url('/Transaksi_lain/P_tvi_aktifasi/action'); ?>"+"?id="+id+"&status=0");
        }else{
            // $("#action").html("Aktif");
            // $("#action").attr("class","btn btn-success");
            // $("#action").attr("href","<?= site_url('/Transaksi_lain/P_tvi_aktifasi/action'); ?>"+"?id="+id+"&status=1");
        }
    }
</script>