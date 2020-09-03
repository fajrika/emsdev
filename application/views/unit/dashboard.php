<link rel="stylesheet" href="<?= base_url(); ?>vendors/select2/dist/css/select2.min.css">
<script src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<style type="text/css">
    @keyframes lds-double-ring {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes lds-double-ring {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes lds-double-ring_reverse {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        100% {
            -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
        }
    }

    @-webkit-keyframes lds-double-ring_reverse {
        0% {
            -webkit-transform: rotate(0);
            transform: rotate(0);
        }

        100% {
            -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
        }
    }

    .lds-double-ring {
        position: absolute;
        z-index: 99;
        margin-top: 20%;
    }

    .lds-double-ring div {
        position: absolute;
        width: 160px;
        height: 160px;
        top: 20px;
        left: 20px;
        border-radius: 50%;
        border: 8px solid #000;
        border-color: #1d3f72 transparent #1d3f72 transparent;
        -webkit-animation: lds-double-ring 2s linear infinite;
        animation: lds-double-ring 2s linear infinite;
    }

    .lds-double-ring div:nth-child(2) {
        width: 140px;
        height: 140px;
        top: 30px;
        left: 30px;
        border-color: transparent #5699d2 transparent #5699d2;
        -webkit-animation: lds-double-ring_reverse 2s linear infinite;
        animation: lds-double-ring_reverse 2s linear infinite;
    }

    .lds-double-ring {
        width: 200px !important;
        height: 200px !important;
        -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
        transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
    }

    .modal-footer {
        background-color: #ddd;
    }

    .dataTables_length {
        display: none
    }

    .dataTables_info {
        display: none
    }

    #DataTables_Table_1 thead {
        display: none
    }

    .dataTables_paginate {
        display: none
    }

    .modal-content {
        height: inherit
    }

    .col-md-4>.x_panel {
        min-height: 600px;
    }

    .clearfix {
        margin-bottom: 5px;
    }
</style>
<div class="right_col" role="main">
    <div id="loading" class="lds-css ng-scope" hidden>
        <div style="width:100%;height:100%" class="col-md-offset-4 lds-double-ring">
            <div></div>
            <div></div>
        </div>
    </div>
    <div class>
        <div class="page-title">
            <div class="title_left" style="margin-bottom: 10px">
                <h3>
                    Rincian Unit
                </h3>
            </div>
            <div class="clearfix"></div>
            <div id='content' class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group" style="margin-top:20px">
                                    <label class="control-label col-lg-2 col-md-2 col-sm-12 col-md-offset-2" style="margin-top:10px">
                                        Kawasan - Blok - Unit - Pemilik:
                                    </label>
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <select id='unit' class='col-md-12 form-control select2'>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Info<small>Unit</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>UID (Mobile Apps)</td>
                                                <td class="uid_mobile_app">-</td>
                                            </tr>
                                            <tr>
                                                <td>Purpose Use</td>
                                                <td class="purpose_use">-</td>
                                            </tr>
                                            <tr>
                                                <td>Type Unit</td>
                                                <td class="type-unit">-</td>
                                            </tr>
                                            <tr>
                                                <td>Golongan</td>
                                                <td class="golongan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Tanah</td>
                                                <td class="luas-tanah">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Bangunan</td>
                                                <td class="luas-bangunan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Taman</td>
                                                <td class="luas-taman">-</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal ST ( dd/mm/yyy )</td>
                                                <td class="tanggal-st">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="read_more_unit">
                                        <button class="btn btn-primary col-md-12" onclick="window.open('http://localhost/emsdev-master/index.php/P_master_unit/','_blank')">Read More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Info<small>Unit</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>UID (Mobile Apps)</td>
                                                <td class="uid_mobile_app">-</td>
                                            </tr>
                                            <tr>
                                                <td>Purpose Use</td>
                                                <td class="purpose_use">-</td>
                                            </tr>
                                            <tr>
                                                <td>Type Unit</td>
                                                <td class="type-unit">-</td>
                                            </tr>
                                            <tr>
                                                <td>Golongan</td>
                                                <td class="golongan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Tanah</td>
                                                <td class="luas-tanah">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Bangunan</td>
                                                <td class="luas-bangunan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Taman</td>
                                                <td class="luas-taman">-</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal ST ( dd/mm/yyy )</td>
                                                <td class="tanggal-st">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="read_more_unit">
                                        <button class="btn btn-primary col-md-12" onclick="window.open('http://localhost/emsdev-master/index.php/P_master_unit/','_blank')">Read More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Info<small>Unit</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>UID (Mobile Apps)</td>
                                                <td class="uid_mobile_app">-</td>
                                            </tr>
                                            <tr>
                                                <td>Purpose Use</td>
                                                <td class="purpose_use">-</td>
                                            </tr>
                                            <tr>
                                                <td>Type Unit</td>
                                                <td class="type-unit">-</td>
                                            </tr>
                                            <tr>
                                                <td>Golongan</td>
                                                <td class="golongan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Tanah</td>
                                                <td class="luas-tanah">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Bangunan</td>
                                                <td class="luas-bangunan">-</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Taman</td>
                                                <td class="luas-taman">-</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal ST ( dd/mm/yyy )</td>
                                                <td class="tanggal-st">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="read_more_unit">
                                        <button class="btn btn-primary col-md-12" onclick="window.open('http://localhost/emsdev-master/index.php/P_master_unit/','_blank')">Read More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#unit').select2({
        width: 'resolve',
        placeholder: 'Kawasan - Blok - Unit - Pemilik',
        minimumInputLength: 1,
        ajax: {
            url: "<?= site_url() ?>/Transaksi/P_unit/get_ajax_unit",
            data: params => params.term,
            processResults: data => ({
                results: data
            })
        }
    });
</script>