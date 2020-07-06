<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="float:right">
    <h2>
        <button class="btn btn-primary" onClick="window.location.href='<?= site_url(); ?>/transaksi_lain/p_tvi_registrasi/add'">
            <i class="fa fa-plus"></i>
            Tambah
        </button>
        <button class="btn btn-warning" onClick="window.history.back()" disabled>
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/p_tvi_registrasi'">>
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
                            <th>Status Tagihan</th>
                            <th>Status Registrasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrasis as $i => $registrasi): ?>
                        <tr>
                            <td><?=++$i?></td>
                            <td><?=$registrasi->unit?></td>
                            <td><?=$registrasi->customer_name?></td>
                            <td><?=$registrasi->isp_name?></td>
                            <td><?=$registrasi->paket_name?></td>
                            <td><?=$registrasi->status_tagihan?></td>
                            <td><?=$registrasi->status_registrasi?></td>
                            <td class='col-md-1'>
                                <a href='<?=site_url("transaksi_lain/P_tvi_registrasi/edit?id=$registrasi->id") ?>' class='btn btn-sm btn-primary col-md-12'>
                                    <i class='fa fa-pencil'></i>
                                </a>
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
<div class="modal fade" id="modal_delete_m_n" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Apakah anda yakin untuk mendelete data ini ?<span class="grt"></span> ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <span id="preloader-delete"></span>
                </br>
                <a class="btn btn-danger" id="delete_link_m_n" href="">Delete</a>
                <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Cancel</button>

            </div>
        </div>
    </div>
</div>
<script>
    function confirm_modal(id) {
        jQuery('#modal_delete_m_n').modal('show', {
            backdrop: 'static',
            keyboard: false
        });
        document.getElementById('delete_link_m_n').setAttribute("href", "<?= site_url('/transaksi_lain/p_tvi_registrasi/delete?id="+id+"'); ?>");
        document.getElementById('delete_link_m_n').focus();
    }
</script>