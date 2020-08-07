<script>
    $(function() {
        $("#source,#denda_jenis_service,#project_id").select2({
            width: '100%',
            placeholder: "Pilih salah satu",
        });
        $("#formSync").submit((e) => {
            e.preventDefault();

            $(".progress-bar.progress-bar-striped.progress-bar-animated").attr('style', 'width: 100%').html('Prepare');
            // if (!($('.modal.in').length)) {}
            $('#modal-progress').modal('show')
            $('#modal-progress').modal({
                backdrop: false,
                show: true
            });

            $('.modal-dialog').draggable({
                handle: ".modal-header"
            });
            $.ajax({
                type: "POST",
                data: $("#formSync").serialize(),
                url: "<?= site_url("Sync/Desktop_tagihan_air/telahDiMigrasi") ?>",
                dataType: "html",
                success: function(data) {
                    console.log("telah di migrasi " + data);
                    $.ajax({
                        type: "POST",
                        data: $("#formSync").serialize(),
                        url: "<?= site_url("Sync/Desktop_tagihan_air/belumDiMigrasi") ?>",
                        dataType: "html",
                        success: function(data) {
                            console.log("belum di migrasi " + data);
                            $.ajax({
                                type: "POST",
                                data: $("#formSync").serialize(),
                                url: "<?= site_url("Sync/Desktop_tagihan_air/save") ?>",
                                dataType: "html",
                                success: function(data) {
                                    console.log("save di migrasi " + data);

                                }
                            });
                        }
                    });
                }
            });



        })

    });
</script>