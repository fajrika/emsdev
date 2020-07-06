<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>


<!-- switchery -->
<link href="<?= base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- date time picker -->
<script type="text/javascript" src="<?= base_url(); ?>vendors/moment/min/moment.min.js"></script>

<link href="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<!DOCTYPE html>
<div style="float:right">
    <h2>
        <button class="btn btn-primary" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/p_tvi_registrasi'">
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.href='<?= site_url() ?>/transaksi_lain/p_tvi_registrasi/add'">
            <i class="fa fa-repeat"></i>
            Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
    <form id="form" data-parsley-validate="" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate="" method="post" action="<?= site_url() ?>/transaksi_lain/p_tvi_registrasi/save">


        <div class="col-md-6">

        </div>
        <div class="clear-fix"></div>
        <div class="row" style="margin-top: 35px;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Unit</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select required id="unit_id" name="unit_id" class="form-control select2">
                                <option value="" selected disabled=>--Pilih Unit--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Bangunan </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback right" aria-hidden="true">(m<sup>2</sup>)</span>
                            <input id="luas_bangunan" name="luas_bangunan" class="form-control text-right" placeholder="Luas Bangunan" readonly style="padding-right: 50px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Tanah </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback right" aria-hidden="true">(m<sup>2</sup>)</span>
                            <input id="luas_tanah" name="luas_tanah" class="form-control text-right" placeholder="Luas Tanah" readonly style="padding-right: 50px;">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tagihan Outstanding</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                            <input id="outstading" name="outstading" class="form-control text-right" style="padding-left: 50px;" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No Hp</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="mobilephone" name="mobilephone" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input placeholder="Email" id="email" name="email" class="form-control" readonly>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <h4 id="label_transaksi">Paket TVI</h4>
        <hr>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Paket</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="paket_id" name="paket_id" class="form-control select2" require>
                        <option value="" selected disabled>--Pilih Paket--</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Durasi</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
					<input id="durasi" class="form-control" disabled>
				</div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bandwidth</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <span class="form-control-feedback right" aria-hidden="true">kB/s</span>
                    <input id="bandwidth" class="form-control text-left" name="bandwidth" readonly>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
					<textarea id="description" class="form-control text-left" name="description" readonly></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Tipe Pemasangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="tipe_pasang" name="tipe_pasang" class="form-control select2" require>
                        <!-- <option value="" selected disabled>--Pilih Paket--</option> -->
                        <option value="1" selected>Pasang Baru</option>
                        <option value="2">Non Pasang Baru</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                    <input id="harga" class="form-control text-right currency" name="harga" style="padding-left: 50px;" readonly>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Pasang Baru</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                    <input id="harga_pasang_baru" class="form-control text-right currency" name="harga_pasang_baru" style="padding-left: 50px;" readonly>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <h4 id="label_transaksi">Transaksi</h4>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group start">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tgl Rencana Aktifasi</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class='input-group date '>
                                <input type="text" class="form-control" name="tgl_rencana_aktifasi" id="tgl_rencana_aktifasi" placeholder="Masukkan Tanggal Rencana Mulai" value='<?= date('d-m-Y') ?>'>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea id='keterangan2' class="form-control" name="keterangan" placeholder="Masukkan keterangan"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Paket (Progresif)</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                            <input id="harga_progresif" class="form-control text-right" name="harga_progresif" style="padding-left: 50px;" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Diskon</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                            <input id="nilai_diskon" class="form-control text-right" name="nilai_diskon" style="padding-left: 50px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Bayar</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <span class="form-control-feedback left" aria-hidden="true">Rp.</span>
                            <input id="total" class="form-control text-right" name="total" style="padding-left: 50px;" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="center-margin">
                <button class="btn btn-primary" type="reset">Reset</button>
                <button type="submit" class="btn btn-success" id="submit">Submit</button>
            </div>
        </div>


    </form>
</div>
</div>

<script type="text/javascript">
    function currency(input) {
        var input = input.toString().replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt(input, 10) : 0;
        return (input === 0) ? "" : input.toLocaleString("en-US");
    }

    function formatNumber(data) {
        data = unformatNumber(data);
        data = data.toString().replace(/,/g, "");
        data = parseInt(data) ? parseInt(data) : 0;
        return data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    }

    function unformatNumber(data) {
        return data.toString().replace(/,/g, "");
    }

    $(function() {
        var tgl_terakhir = parseInt(new Date(2020,05,0).getDate());
        $("#tgl_rencana_aktifasi").on("dp.change",function(){
            console.log("test");
            var harga = unformatNumber($("#harga").val());
            var tgl_rencana_aktif = parseInt($("#tgl_rencana_aktifasi").val().substr(0,2));
            var harga_progresif = (tgl_terakhir - tgl_rencana_aktif + 1)* harga / tgl_terakhir
            if(harga < harga_progresif)
                $("#harga_progresif").val(formatNumber(harga));
            else
                $("#harga_progresif").val(formatNumber(harga_progresif));
            $("#nilai_diskon").trigger("keyup");

        })
        $("#nilai_diskon").keyup(function(){
            $("#nilai_diskon").val(formatNumber($("#nilai_diskon").val())); 
            
            var harga_progresif = unformatNumber($("#harga_progresif").val());
            var harga_pasang_baru = unformatNumber($("#harga_pasang_baru").val());
            var total_harga = parseInt(harga_progresif) + parseInt(harga_pasang_baru) - parseInt(unformatNumber($("#nilai_diskon").val()));
            if($("#tipe_pasang").val() == 1)
                var total_harga = parseInt(harga_progresif) + parseInt(harga_pasang_baru) - parseInt(unformatNumber($("#nilai_diskon").val()));
            else
                var total_harga = parseInt(harga_progresif) - parseInt(unformatNumber($("#nilai_diskon").val()));
            $("#total").val(formatNumber(total_harga)); 
        })
        $("#tipe_pasang").change(function(){
            $("#nilai_diskon").trigger("keyup");
        })
        $("#unit_id").select2({
            width: 'resolve',
            minimumInputLength: 1,
            placeholder: 'Kawasan - Blok - Unit - Pemilik',
            ajax: {
                type: "GET",
                dataType: "json",
                url: "<?= site_url("transaksi_lain/p_tvi_registrasi/get_ajax_unit") ?>",
                data: function(params) {
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
        });
        $("#unit_id").change(function() {
            $.ajax({
                type: "GET",
                data: {
                    id: $(this).val()
                },
                url: "<?= site_url("transaksi_lain/p_tvi_registrasi/get_ajax_unit_detail") ?>",
                dataType: "json",
                success: function(data) {
                    $("#outstading").val(formatNumber(data.outstading));
                    $("#luas_bangunan").val(data.luas_bangunan);
                    $("#luas_tanah").val(data.luas_tanah);
                    $("#mobilephone").val(data.mobilephone);
                    $("#email").val(data.email);

                }
            })
        })
        $("#paket_id").select2({
            width: 'resolve',
            minimumInputLength: 1,
            placeholder: 'Nama Paket - Kode Paket, Note: isi space untuk melihat semua',
            ajax: {
                type: "GET",
                dataType: "json",
                url: "<?= site_url("transaksi_lain/p_tvi_registrasi/get_ajax_paket") ?>",
                data: function(params) {
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
        });
        $("#paket_id").change(function() {
            $.ajax({
                type: "GET",
                data: {
                    id: $(this).val()
                },
                url: "<?= site_url("transaksi_lain/p_tvi_registrasi/get_ajax_paket_detail") ?>",
                dataType: "json",
				success: function(data) {
					var tipe_durasi = data.tipe_durasi == 1?' Hari':data.tipe_durasi==2?' Bulan':' Tahun';
					$("#harga").val(formatNumber(data.harga));
					$("#harga_pasang_baru").val(formatNumber(data.harga_pasang_baru));
					$("#durasi").val(data.durasi + tipe_durasi);
					$("#bandwidth").val(formatNumber(data.bandwidth));
					$("#description").val(data.description);
                    $("#tgl_rencana_aktifasi").trigger("dp.change");
                    $("#nilai_diskon").trigger("keyup");

                }
            })
        })
        $('#tgl_rencana_aktifasi').datetimepicker({
            viewMode: 'days',
            format: 'DD-MM-YYYY',
            minDate: "<?= date('Y-m-d') ?>"
        });
    });
</script>