<script>
    const row = $(".e-row").clone()[0].outerHTML;
    const column = $(".e-column").clone()[0].outerHTML;
    const item = $(".tbody-item").clone()[0].innerHTML;
    $("#btn-add-row").click(function(e) {
        $("#input-add-row").get(0).value++;
        $("#outer-form").append(row);
        re_render();
    })

    $("body").on("click", ".btn-add-column", function(e) {
        $(this).parents('.item').find(".input-add-column").get(0).value++
        $(this).parents('.outer-column').append(column);
        re_render();
    }).on("click", ".btn-add-item", function(e) {
        $(this).closest('.x_content').find(".tbody-item").append(item);
        re_render();
    }).on("click", "#btn-remove-row", function() {
        $(this).closest('.e-row').remove();
        re_render();
    }).on("click", ".btn-remove-column", function() {
        $(this).closest('.e-column').remove();
        re_render();
    }).on("click", ".btn-remove-input-item", function() {
        $(this).closest('.tr-item').remove();
        re_render();
    })
    // btn-remove-row
    // btn-remove-column
    // btn-remove-input
    $("#form").submit(function(e) {
        e.preventDefault();
        $("#form").serialize();
        $.ajax({
            type: "POST",
            data: $("#form").serialize(),
            url: "ajax_builder",
            dataType: "html",
            success: function(data) {
                console.log(data);
                if ($("#content").children().length > 2) {
                    $("#content").children().last().remove()
                    $("#content").children().last().remove()
                }
                $("#content").append(data);
                $("#content").append("<div class='col-md-12'><div class='x_panel'><div class='x_title'><h2>Result Builder - Code </h2><button class='btn btn-success col-md-1 float-right' onClick='copyFunction()' type='button'>Copy</button><div class='clearfix'></div></div><div class='x_content'><xmp id ='copy'>" + data + "</xmp></div></div></div>");


            }
        });
    })

    function copyFunction() {
        const copyText = document.getElementById("copy").textContent;
        const textArea = document.createElement('textarea');
        textArea.textContent = copyText;
        document.body.append(textArea);
        textArea.select();
        textArea.setSelectionRange(0, 99999);
        document.execCommand("copy");
        $("body").children('textarea').remove()
        alert("Copied the code");
    }

    function re_render() {
        $(".e-row").each(function(i) {
            $(this).find(".x_title").find("h2").html("Row - " + (i + 1));
            $(this).find(".e-column").each(function(j) {
                $(this).find(".x_title").find("h2").html("Column - " + (j + 1));
            })
            $(this).find(".input-add-column").val($(this).find(".e-column").length);
        })
        $("#input-add-row").val(row);

        var column = 0;
        $(".e-row").each(function(i) {
            $(this).find(".tbody-item").each(function(j) {
                $(this).find(".tr-item").each(function(k) {
                    $(this).find(".input-item").each(function(l) {
                        $(this).attr("name", "item[" + i + "][" + j + "][" + k + "][" + $(this).attr('sub') + "]");
                    })
                })
            })
        })
    }
</script>