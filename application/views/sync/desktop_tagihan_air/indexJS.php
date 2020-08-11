<script>
    var data1 = 0;
    var data2 = 0;
    var data3 = 0;
    var data4 = 0;
    var data5 = 0;
    var data6 = 0;
    var checkF;
    const save = () => {

        $.ajax({
            type: "POST",
            data: $("#formSync").serialize(),
            url: "<?= site_url("Sync/Desktop_tagihan_air/save") ?>",
            dataType: "html",
            beforeSend: function() {
                $("#data-migrasi6").val(data6);
            },
            success: function(newData) {
                if (data6 != -1) {
                    data2 = parseInt(data2) + parseInt(newData);
                    data3 = parseInt(data1) + parseInt(data2);
                    data5 = parseInt(data5) - parseInt(newData);
                    data6 = parseInt(data6) + parseInt(newData);
                    persen = Math.round(100 * data6 / data5 * 100) / 100;
                    console.log(`data1 : ${data1}`);
                    console.log(`data2 : ${data2}`);
                    console.log(`data3 : ${data3}`);
                    console.log(`data4 : ${data4}`);
                    console.log(`data5 : ${data5}`);
                    console.log(`data6 : ${data6}`);
                    // $("#pb-length").attr('style', `width: ${persen}%`);
                    // $("#pb-label").html(`${persen}%`);
                    $("#data-migrasi2").val(data2);
                    $("#data-migrasi3").val(data3);
                    $("#data-migrasi5").val(data5);
                    $("#data-migrasi6").val(data6);
                    console.log(newData);
                    save();
                } else {
                    clearInterval(checkF);
                }
            }
        });
    }
    var persentase = 0;
    const check = () => {
        checkF = setInterval(() => {
            $.ajax({
                type: "POST",
                data: $("#formSync").serialize(),
                url: "<?= site_url("Sync/Desktop_tagihan_air/progress") ?>",
                dataType: "html",
                success: function(newData) {
                    persentase = Math.round((newData - data1) * 100 / data5 * 100) / 100;
                    $("#pb-length").attr('style', `width: ${persen}%`);
                    $("#pb-label").html(`${persen}%`);
                },
                error: function(xhr, status, error) {
                    $("#modal-footer").html("<h6 class=''col-lg-8 col-md-8 col-sm-8 justify-content-center align-self-center'' style=''color: red;''>Error, koneksi Terputus silahkan di reload</h6>" +
                        "<button class=''btn btn-success''>Reload</button>" +
                        "<button type=''button'' class=''btn btn-secondary offset-md-10'' data-dismiss=''modal'' disabled=''>Close</button>");
                }
            });
        }, 5000);
    }
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
                beforeSend: function() {
                    $("#data-migrasi1").val('Process...');
                    $("#data-migrasi2").val(data2);
                    $("#data-migrasi3").val('Process...');
                    $("#data-migrasi4").val(0);
                    $("#data-migrasi5").val(0);
                    $("#data-migrasi6").val(0);
                },
                success: function(data1) {
                    data3 = data1;
                    $("#data-migrasi1").val(data1);
                    $("#data-migrasi3").val(data3);
                    $.ajax({
                        type: "POST",
                        data: $("#formSync").serialize(),
                        url: "<?= site_url("Sync/Desktop_tagihan_air/belumDiMigrasi") ?>",
                        dataType: "html",
                        beforeSend: function() {
                            $("#data-migrasi4").val('Process...');
                            $("#data-migrasi5").val('Process...');
                        },
                        success: function(data4) {
                            data5 = data4;
                            $("#data-migrasi4").val(data4);
                            $("#data-migrasi5").val(data5);
                            data6 = 0;
                            $("#pb-length").html('');

                            save();
                            check();
                        }
                    });
                }
            });



        })

    });
</script>