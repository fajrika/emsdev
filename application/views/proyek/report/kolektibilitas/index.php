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
                            <thead>
                                <tr>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Nilai Tagihan</th>
                                    <th class="text-center">Aging s.d Bln Ini</th>
                                    <th class="text-center">Collected s.d Bln Ini</th>
                                    <th class="text-center">Target Collected s.d Bln Ini</th>
                                    <th class="text-center">Tunggakan Bln Ini</th>
                                    <th class="text-center">% Coll --> A / E X 100%</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_unit">
                                <?php
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>