<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div style="float:right">
    <h2>
        <a href="<?=site_url()?>" class="btn btn-primary" id="add-data">
            <i class="fa fa-edit"></i> Tambah
        </a>
        <button class="btn btn-success" onClick="window.location.href='<?=site_url('transaksi/p_maintenance_meter_air');?>'">
            <i class="fa fa-repeat"></i> Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
    <div class="x_content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table class="table table-striped jambo_table tableDT">
                        <tfoot id="tfoot" style="display: table-header-group">
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Periode</th>
                                <th>Kawasan</th>
                                <th>Blok</th>
                                <th>Unit</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Pemakaian</th>
                                <th hidden>Action</th>
                            </tr>
                        </tfoot>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Periode</th>
                                <th>Kawasan</th>
                                <th>Blok</th>
                                <th>Unit</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Pemakaian</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="x_content">
    <div class="modal" id="modal_meter_air" data-backdrop="static" data-keyboard="false" style="width:100vw">
        <div class="modal-dialog" style="width: 40vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Penggantian Meter Air<span class="grt"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="meter-form" data-parsley-validate="" novalidate="">
                        <div class="form-group">
                            <label>Tanggal Transaksi *</label>
                            <input type="text" class="form-control" name="tgl_transaksi" id="tgl_transaksi" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Nomor Transaksi *</label>
                            <input type="text" class="form-control" name="nomor_transaksi" id="nomor_transaksi" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Blok / Unit *</label>
                            <select name="no_unit" id="no_unit" class='col-md-12 form-control select2'></select>
                        </div>
                        <div class="form-group">
                            <label>Alasan Ganti *</label>
                            <textarea class="form-control" name="alasan_ganti" id="alasan_ganti" rows="5" style="resize: vertical;"></textarea>
                        </div>
                        <div class="form-group">
                            <label>No. Meter Baru *</label>
                            <input type="text" class="form-control" name="no_meter_baru" id="no_meter_baru" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Nilai Meter Awal *</label>
                            <input type="text" class="form-control" name="nilai_meter_baru" id="nilai_meter_baru" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Aktif *</label>
                            <input type="text" class="form-control" name="tgl_aktif" id="tgl_aktif" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Periode Pakai *</label>
                            <input type="text" class="form-control" name="periode_pakai" id="periode_pakai" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>No. Meter Lama *</label>
                            <input type="text" class="form-control" name="no_meter_lama" id="no_meter_lama" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Nilai Meter Akhir *</label>
                            <input type="text" class="form-control" name="nilai_meter_akhir" id="nilai_meter_akhir" placeholder="....">
                        </div>
                        <div class="form-group">
                            <label>Biaya Pasang *</label>
                            <input type="text" class="form-control" name="biaya_pasang" id="biaya_pasang" placeholder="....">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#add-data', function(e){
            e.preventDefault();
            // alert($(this).attr('href'));
            $('#modal_meter_air').modal('show');
        });
    });
</script>
<style type="text/css">
    tfoot input {
        border: 1px solid #d1d1d1;
        border-radius: 0;
        padding: 5px 5px;
    }
</style>