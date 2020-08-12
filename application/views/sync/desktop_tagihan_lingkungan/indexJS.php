<script>
    var data1 = 0;
    var data2 = 0;
    var data3 = 0;
    var data4 = 0;
    var data5 = 0;
    var data6 = 0;
    var checkF;
    var dataMigrate = [];
    const getDataBeforeMigrate = () => {
        $.ajax({
            type: "POST",
            data: $("#formSync").serialize(),
            url: "<?= site_url("Sync/Desktop_tagihan_air/getDataBeforeMigrate") ?>",
            dataType: "html",
            beforeSend: function() {
                $("#data-migrasi6").val(data6);
            },
            error: function(xhr, status, error) {
                $("#modal-footer").html("<h6 class='col-lg-8 col-md-8 col-sm-8 justify-content-center align-self-center'' style='color: red;'>Error, koneksi Terputus silahkan di reload</h6>" +
                    "<button id='btn-reload-process' class='btn btn-success'>Reload</button>" +
                    "<button type='button' class='btn btn-secondary offset-md-10' data-dismiss='modal' disabled>Close</button>");
            },
            success: function(newData) {
                console.log(newData);
                dataMigrate = JSON.parse(newData);
                do {
                    save(dataMigrate.splice(0, 10));
                } while (dataMigrate.length != 0);
                if (newData != '[]') {
                    getDataBeforeMigrate();
                }
            }
        })
    }
    const save = (data) => {

        $.ajax({
            type: "POST",
            data: `${$("#formSync").serialize()}&data=${JSON.stringify(data)}`,
            url: "<?= site_url("Sync/Desktop_tagihan_air/save") ?>",
            dataType: "html",
            beforeSend: function() {
                $("#data-migrasi6").val(data6);
            },
            error: function(xhr, status, error) {
                $("#modal-footer").html("<h6 class=''col-lg-8 col-md-8 col-sm-8 justify-content-center align-self-center'' style=''color: red;''>Error, koneksi Terputus silahkan di reload</h6>" +
                    "<button class=''btn btn-success''>Reload</button>" +
                    "<button type=''button'' class=''btn btn-secondary offset-md-10'' data-dismiss=''modal'' disabled=''>Close</button>");
            },
            success: function(newData) {
                if (data6 != -1) {
                    data2 = parseInt(data2) + parseInt(newData);
                    data3 = parseInt(data1) + parseInt(data2);
                    data5 = parseInt(data5) - parseInt(newData);
                    data6 = parseInt(data6) + parseInt(newData);
                    persen = Math.round(100 * data6 / data5 * 100) / 100;
                    $("#data-migrasi2").val(data2);
                    $("#data-migrasi3").val(data3);
                    $("#data-migrasi5").val(data5);
                    $("#data-migrasi6").val(data6);
                    $("#pb-length").attr('style', `width: ${persen}%`);
                    $("#pb-label").html(`${persen}%`);
                }
            }
        });
    }

    var persentase = 0;
    $(function() {
        $("#source,#denda_jenis_service,#project_id").select2({
            width: '100%',
            placeholder: "Pilih salah satu",
        });

        $("body").on("click", "#btn-reload-process", () => {
            $("#formSync").trigger('submit');
        });
        $("#formSync").submit((e) => {
            e.preventDefault();
            var d = new Date;
            var dformat = [
                ("0" + d.getDate()).slice(-2),
                ("0" + d.getMonth() + 1).slice(-2),
                d.getFullYear()
            ].join('/') + ' ' + [d.getHours(),
                d.getMinutes(),
                d.getSeconds()
            ].join(':');
            $("#pb-length").attr('style', `width: 100%`);
            $("#pb-label").html('prepare');
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
                error: function(xhr, status, error) {
                    $("#modal-footer").html("<h6 class=''col-lg-8 col-md-8 col-sm-8 justify-content-center align-self-center'' style=''color: red;''>Error, koneksi Terputus silahkan di reload</h6>" +
                        "<button class=''btn btn-success''>Reload</button>" +
                        "<button type=''button'' class=''btn btn-secondary offset-md-10'' data-dismiss=''modal'' disabled=''>Close</button>");
                },
                success: function(tmp) {
                    data1 = tmp;
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
                        error: function(xhr, status, error) {
                            $("#modal-footer").html("<h6 class=''col-lg-8 col-md-8 col-sm-8 justify-content-center align-self-center'' style=''color: red;''>Error, koneksi Terputus silahkan di reload</h6>" +
                                "<button class=''btn btn-success''>Reload</button>" +
                                "<button type=''button'' class=''btn btn-secondary offset-md-10'' data-dismiss=''modal'' disabled=''>Close</button>");
                        },
                        success: function(data4) {
                            data5 = data4;
                            $("#data-migrasi4").val(data4);
                            $("#data-migrasi5").val(data5);
                            data6 = 0;
                            $("#pb-length").attr('style', `width: 0%`);
                            $("#pb-label").html('0%');
                            getDataBeforeMigrate();
                        }
                    });
                }
            });



        })

    });
</script>