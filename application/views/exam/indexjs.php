<script type="text/javascript" src="<?= base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function() {

        $(".datetimepicker").datetimepicker({
            viewMode: 'years',
            format: 'DD/MM/YYYY'
        })
        $("#kawasan").select2({
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
        });
        $("#form-report").submit(function(e) {
            e.preventDefault();
            // return false;

        });
    });
</script>