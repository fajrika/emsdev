<script type="text/javascript" src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function() {
        $(".datetimepicker").datetimepicker({
            viewMode: 'years',
            format: 'DD/MM/YYYY'
        })
        $('.select2').select2({
            width: '100%'
        });
        /*$("#kawasan").select2({
            width: '100%',
            // resize:true,
            minimumInputLength: 1,
            placeholder: 'Kode - Name',
            ajax: {
                type: "GET",
                dataType: "json",
                url: "<?= site_url() ?>/Report/P_Exam/ajax_get_kawasan",
                data: function(params) {
                    return {
                        data: params.term
                    }
                },
                processResults: function(data) {
                    console.log(data);
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                }
            }
        });*/
        var used = false;
        $("#form-report").submit(function(e){
            e.preventDefault();
            var ErrMsg   = '';
            var ErrCount = 0;
            if ($('#kawasan').val() == '') {
                ErrMsg += 'Kawasan masih kosong\n';
                ErrCount++;
            }
            if ($('#periode_awal').val() == '') { 
                ErrMsg += 'Periode collectability masih kosong';
                ErrCount++;
            } 
            if (ErrCount > 0) 
            {
                alert(ErrMsg);
            }
            else
            {
                if (used == false) 
                {
                    $('.table-collect tbody tr td').each(function(){
                        var unique_id = $(this).attr('id');
                        if (unique_id !== undefined) 
                        {
                            var split = unique_id.split('_');
                            var month = split[0];
                            var id_column = split[1];
                            if (id_column == '1') {
                                $.ajax({
                                    url: $('#form-report').attr('action'),
                                    cache: false,
                                    type: "POST",
                                    data: {
                                        month: month,
                                        column_ke: id_column,
                                        periode_awal: $('#periode_awal').val()
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        $('#'+data.bulan_ke+'_'+data.column_ke).text(data.nilai_tagihan);
                                        used = true;
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
    });
</script>