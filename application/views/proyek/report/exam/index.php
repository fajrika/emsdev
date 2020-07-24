<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>List </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <form action="<?=site_url('report/p_kolektabilitas/generate');?>" id="form-report" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                        <div class="col-md-6">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-6 label-align" for="kawasan">Kawasan
                                </label>
                                <div class="col-md-9 col-sm-6 ">
                                    <select id='kawasan' name="id_kawasan" class='col-md-12 form-control select2'>
                                        <option value="">....</option>
                                        <?php
                                        foreach ($kawasan as $v) {
                                            echo ("<option value='$v->id'>$v->code - $v->name</option>");
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-6 label-align" for="first-name">Posisi Collectability
                                </label>
                                <div class="col-md-9 col-sm-6 ">
                                    <div class='input-group date datetimepicker'>
                                        <input type="text" class="form-control datetimepicker" name="periode_awal" id="periode_awal" placeholder="Dari Periode" required>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </span>
                                    </div>
                                    <!-- <input type="text" id="first-name" required="required" class="form-control "> -->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3" style="text-align: center;">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Generate</button>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table-collect" cellspacing="0" width="100%">
                            <!-- <tfoot style="display: table-header-group">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Nilai Tagihan</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                </tr>
                            </tfoot> -->
                            <tfoot style="display: table-header-group">
                                <tr>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Nilai Tagihan</th>
                                    <th class="text-center">Count</th>
                                    <th class="text-center">Komulatif Tagihan</th>
                                    <th class="text-center">Tahun Sebelumnya</th>
                                    <th class="text-center">Bulan Sebelumnya</th>
                                    <th class="text-center">Bulan Ini</th>
                                    <th class="text-center">Penerimaan di Muka</th>
                                    <th class="text-center">Diskon</th>
                                    <th class="text-center">Pemutihan</th>
                                    <th class="text-center">% Coll Bulan Berjalan</th>
                                    <th class="text-center">Tagihan Tahun Berjalan</th>
                                    <th class="text-center">Akumulasi Tanpa Penerimaan Dimuka</th>
                                    <th class="text-center">% Coll</th>
                                    <th class="text-center">Dengan Penerimaan Dimuka</th>
                                    <th class="text-center">Akumulasi dengan Penerimaan di Muka</th>
                                    <th class="text-center">Akumulasi dengan Penerimaan di Muka</th>
                                </tr>
                            </tfoot>
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">Bulan</th>
                                    <th class="text-center" rowspan="2">Nilai Tagihan</th>
                                    <th class="text-center" rowspan="2">Count</th>
                                    <th class="text-center" rowspan="2">Komulatif Tagihan</th>
                                    <th class="text-center" colspan="7">Penerimaan</th>
                                    <th class="text-center" colspan="5">Penerimaan</th>
                                    <th class="text-center" rowspan="2">% Coll</th>
                                </tr>
                                <tr>
                                    <th>Tahun Sebelumnya</th>
                                    <th>Bulan Sebelumnya</th>
                                    <th>Bulan Ini</th>
                                    <th>Penerimaan di Muka</th>
                                    <th>Diskon</th>
                                    <th>Pemutihan</th>
                                    <th>% Coll Bulan Berjalan</th>
                                    <th>Tagihan Tahun Berjalan</th>
                                    <th>Akumulasi Tanpa Penerimaan Dimuka</th>
                                    <th>% Coll</th>
                                    <th>Dengan Penerimaan Dimuka</th>
                                    <th>Akumulasi dengan Penerimaan di Muka</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // $nomor=0;
                                // for ($i=1; $i<=12; $i++) { 
                                //     for ($j=1; $j<=17; $j++) {
                                //         echo $i.' '.$nomor++;
                                //         echo "<br>";
                                //         if ($j==17) {
                                //             echo "<br>";
                                //             $nomor=0;
                                //         }
                                //     }
                                // }

                                $total_data   = 12;
                                $number_left  = 1;
                                $number_right = 1;
                                $month        = array(1=>'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                for ($i=1; $i<=$total_data; $i++) 
                                { 
                                    for ($j=$total_data; $j<=$total_data; $j++) 
                                    {
                                        echo "
                                        <tr>
                                            <td>".$month[$i]."</td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                            <td id='".$number_left.'_'.$number_right++."'></td>
                                        </tr>
                                        ";

                                        if ($j = $total_data) {
                                            $number_left  = $number_left+1;
                                            $number_right = 1;
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                            <!-- <tbody>
                                <tr>
                                    <td>January</td>
                                    <td id="1.1"></td>
                                    <td id="1.2"></td>
                                    <td id="1.3"></td>
                                    <td id="1.4"></td>
                                    <td id="1.5"></td>
                                    <td id="1.6"></td>
                                    <td id="1.7"></td>
                                    <td id="1.8"></td>
                                    <td id="1.9"></td>
                                    <td id="1.10"></td>
                                    <td id="1.11"></td>
                                    <td id="1.12"></td>
                                    <td id="1.13"></td>
                                    <td id="1.14"></td>
                                    <td id="1.15"></td>
                                    <td id="1.16"></td>
                                </tr>
                                <tr>
                                    <td>February</td>
                                    <td id="2.1"></td>
                                    <td id="2.2"></td>
                                    <td id="2.3"></td>
                                    <td id="2.4"></td>
                                    <td id="2.5"></td>
                                    <td id="2.6"></td>
                                    <td id="2.7"></td>
                                    <td id="2.8"></td>
                                    <td id="2.9"></td>
                                    <td id="2.10"></td>
                                    <td id="2.11"></td>
                                    <td id="2.12"></td>
                                    <td id="2.13"></td>
                                    <td id="2.14"></td>
                                    <td id="2.15"></td>
                                    <td id="2.16"></td>
                                </tr>
                                <tr>
                                    <td>March</td>
                                    <td id="3.1"></td>
                                    <td id="3.2"></td>
                                    <td id="3.3"></td>
                                    <td id="3.4"></td>
                                    <td id="3.5"></td>
                                    <td id="3.6"></td>
                                    <td id="3.7"></td>
                                    <td id="3.8"></td>
                                    <td id="3.9"></td>
                                    <td id="3.10"></td>
                                    <td id="3.11"></td>
                                    <td id="3.12"></td>
                                    <td id="3.13"></td>
                                    <td id="3.14"></td>
                                    <td id="3.15"></td>
                                    <td id="3.16"></td>
                                </tr>
                                <tr>
                                    <td>April</td>
                                    <td id="4.1"></td>
                                    <td id="4.2"></td>
                                    <td id="4.3"></td>
                                    <td id="4.4"></td>
                                    <td id="4.5"></td>
                                    <td id="4.6"></td>
                                    <td id="4.7"></td>
                                    <td id="4.8"></td>
                                    <td id="4.9"></td>
                                    <td id="4.10"></td>
                                    <td id="4.11"></td>
                                    <td id="4.12"></td>
                                    <td id="4.13"></td>
                                    <td id="4.14"></td>
                                    <td id="4.15"></td>
                                    <td id="4.16"></td>
                                </tr>
                                <tr>
                                    <td>May</td>
                                    <td id="5.1"></td>
                                    <td id="5.2"></td>
                                    <td id="5.3"></td>
                                    <td id="5.4"></td>
                                    <td id="5.5"></td>
                                    <td id="5.6"></td>
                                    <td id="5.7"></td>
                                    <td id="5.8"></td>
                                    <td id="5.9"></td>
                                    <td id="5.10"></td>
                                    <td id="5.11"></td>
                                    <td id="5.12"></td>
                                    <td id="5.13"></td>
                                    <td id="5.14"></td>
                                    <td id="5.15"></td>
                                    <td id="5.16"></td>
                                </tr>
                                <tr>
                                    <td>June</td>
                                    <td id="6.1"></td>
                                    <td id="6.2"></td>
                                    <td id="6.3"></td>
                                    <td id="6.4"></td>
                                    <td id="6.5"></td>
                                    <td id="6.6"></td>
                                    <td id="6.7"></td>
                                    <td id="6.8"></td>
                                    <td id="6.9"></td>
                                    <td id="6.10"></td>
                                    <td id="6.11"></td>
                                    <td id="6.12"></td>
                                    <td id="6.13"></td>
                                    <td id="6.14"></td>
                                    <td id="6.15"></td>
                                    <td id="6.16"></td>
                                </tr>
                                <tr>
                                    <td>July</td>
                                    <td id="7.1"></td>
                                    <td id="7.2"></td>
                                    <td id="7.3"></td>
                                    <td id="7.4"></td>
                                    <td id="7.5"></td>
                                    <td id="7.6"></td>
                                    <td id="7.7"></td>
                                    <td id="7.8"></td>
                                    <td id="7.9"></td>
                                    <td id="7.10"></td>
                                    <td id="7.11"></td>
                                    <td id="7.12"></td>
                                    <td id="7.13"></td>
                                    <td id="7.14"></td>
                                    <td id="7.15"></td>
                                    <td id="7.16"></td>
                                </tr>
                                <tr>
                                    <td>August</td>
                                    <td id="8.1"></td>
                                    <td id="8.2"></td>
                                    <td id="8.3"></td>
                                    <td id="8.4"></td>
                                    <td id="8.5"></td>
                                    <td id="8.6"></td>
                                    <td id="8.7"></td>
                                    <td id="8.8"></td>
                                    <td id="8.9"></td>
                                    <td id="8.10"></td>
                                    <td id="8.11"></td>
                                    <td id="8.12"></td>
                                    <td id="8.13"></td>
                                    <td id="8.14"></td>
                                    <td id="8.15"></td>
                                    <td id="8.16"></td>
                                </tr>
                                <tr>
                                    <td>September</td>
                                    <td id="9.1"></td>
                                    <td id="9.2"></td>
                                    <td id="9.3"></td>
                                    <td id="9.4"></td>
                                    <td id="9.5"></td>
                                    <td id="9.6"></td>
                                    <td id="9.7"></td>
                                    <td id="9.8"></td>
                                    <td id="9.9"></td>
                                    <td id="9.10"></td>
                                    <td id="9.11"></td>
                                    <td id="9.12"></td>
                                    <td id="9.13"></td>
                                    <td id="9.14"></td>
                                    <td id="9.15"></td>
                                    <td id="9.16"></td>
                                </tr>
                                <tr>
                                    <td>October</td>
                                    <td id="10.1"></td>
                                    <td id="10.2"></td>
                                    <td id="10.3"></td>
                                    <td id="10.4"></td>
                                    <td id="10.5"></td>
                                    <td id="10.6"></td>
                                    <td id="10.7"></td>
                                    <td id="10.8"></td>
                                    <td id="10.9"></td>
                                    <td id="10.10"></td>
                                    <td id="10.11"></td>
                                    <td id="10.12"></td>
                                    <td id="10.13"></td>
                                    <td id="10.14"></td>
                                    <td id="10.15"></td>
                                    <td id="10.16"></td>
                                </tr>
                                <tr>
                                    <td>November</td>
                                    <td id="11.1"></td>
                                    <td id="11.2"></td>
                                    <td id="11.3"></td>
                                    <td id="11.4"></td>
                                    <td id="11.5"></td>
                                    <td id="11.6"></td>
                                    <td id="11.7"></td>
                                    <td id="11.8"></td>
                                    <td id="11.9"></td>
                                    <td id="11.10"></td>
                                    <td id="11.11"></td>
                                    <td id="11.12"></td>
                                    <td id="11.13"></td>
                                    <td id="11.14"></td>
                                    <td id="11.15"></td>
                                    <td id="11.16"></td>
                                </tr>
                                <tr>
                                    <td>December</td>
                                    <td id="12.1"></td>
                                    <td id="12.2"></td>
                                    <td id="12.3"></td>
                                    <td id="12.4"></td>
                                    <td id="12.5"></td>
                                    <td id="12.6"></td>
                                    <td id="12.7"></td>
                                    <td id="12.8"></td>
                                    <td id="12.9"></td>
                                    <td id="12.10"></td>
                                    <td id="12.11"></td>
                                    <td id="12.12"></td>
                                    <td id="12.13"></td>
                                    <td id="12.14"></td>
                                    <td id="12.15"></td>
                                    <td id="12.16"></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td id="13.1"></td>
                                    <td id="13.2"></td>
                                    <td id="13.3"></td>
                                    <td id="13.4"></td>
                                    <td id="13.5"></td>
                                    <td id="13.6"></td>
                                    <td id="13.7"></td>
                                    <td id="13.8"></td>
                                    <td id="13.9"></td>
                                    <td id="13.10"></td>
                                    <td id="13.11"></td>
                                    <td id="13.12"></td>
                                    <td id="13.13"></td>
                                    <td id="13.14"></td>
                                    <td id="13.15"></td>
                                    <td id="13.16"></td>
                                </tr>
                            </tbody> -->
                            <!-- <thead style="display: table-footer-group;">
                                <tr>
                                    <th>Subholding</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                </tr>
                            </thead> -->
                            <!-- <tbody>
                                <tr>
                                    <td>a</td>
                                    <td>gb</td>
                                    <td>c</td>
                                    <td>d</td>
                                    <td>e</td>
                                    <td>4</td>
                                </tr>
                            </tbody> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>